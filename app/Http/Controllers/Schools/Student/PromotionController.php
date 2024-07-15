<?php

namespace App\Http\Controllers\Schools\Student;
use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Models\Student;
use App\Models\Exam;
use Illuminate\Support\Facades\Auth;
use App\Models\Trimester;
use App\Models\ClassRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::user()->can('school-promotion-list')) {
            toastr()->error(  trans('genirale.no_permission_message'), 'Error');
            return redirect()->back();
        }
        return view('pages.schools.promotions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Auth::user()->can('school-promotion-create')) {
            toastr()->error(  trans('genirale.no_permission_message'), 'Error');
            return redirect()->back();
        }
        return view('pages.schools.promotions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->can('school-promotion-create')) {
            toastr()->error(  trans('genirale.no_permission_message'), 'Error');
            return redirect()->back();
        }
        $request->validate([
            'from_section' => 'required|exists:classrooms,id',
            'to_section' => 'required|integer|exists:classrooms,id',
            'academic_year' => 'required|string',
            'academic_year_new' => 'required|string',
        ]);
        DB::beginTransaction();

        // try {
            // return $request;
          $section=  ClassRoom::find($request->from_section);
          $students=  $section->students;

        if($section->students->count() < 1){
            toastr()->error( trans('genirale.error_occurred'), 'Ooops');
            return back();
        }

        // update in table student
        foreach ($students as $student){
            // return $this->is_admin($student);
            // if($this->is_admin($student)==0){
            //     DB::rollback();
            //     toastr()->error(  trans('genirale.no_data_found'), 'Error');
            //     return redirect()->back();
            //     break;
            // }
         

            if($this->is_admin($student)=="yes"){
                $student->section_id=$request->to_section;
                $student->academic_year=$request->academic_year_new;
                $student->save();


                 // insert in to promotions
                 Promotion::create([
                     'student_id'=>$student->id,
                     'school_id'=>getSchool()->id,
                     'from_section'=>$request->from_section,
                     'to_section'=>$request->to_section,
                     'academic_year'=>$request->academic_year,
                     'academic_year_new'=>$request->academic_year_new,
                     'decision'=>"admin",
                 ]);
            }else{

                $student->academic_year=$request->academic_year_new;
                $student->save();


                 // insert in to promotions
                 Promotion::create([
                     'student_id'=>$student->id,
                     'school_id'=>getSchool()->id,
                     'from_section'=>$request->from_section,
                     'to_section'=>$request->from_section,
                     'academic_year'=>$request->academic_year,
                     'academic_year_new'=>$request->academic_year_new,
                     'decision'=>"notAdmin",
                 ]);
            }


        }
        DB::commit();
        toastr()->success( trans('genirale.data_store_successfully'), 'Congrats');
        return redirect()->back();

    // } catch (\Exception $e) {
    //     DB::rollback();
    //     return redirect()->back()->withErrors(['error' =>trans('genirale.error_occurred')]);
    // }

    }
    public function is_admin(Student $student){
        $is_admin="not";
        $sum = 0;
        $trimesters=Trimester::all();
        foreach ($trimesters as $trimester){
            $exams =  Exam::where([
                'student_id'=>$student->id,
                'school_id'=>getSchool()->id,
                'session_year'=>getYearNow()->id,
                'trimester_id'=>$trimester->id,
            ])->get();
            // dd($this->moyentrimester( $exams));
            // if($this->moyentrimester( $exams)==0){
            //     return 0;
            // }
            $sum+=$this->moyentrimester( $exams);
        }
        $moyen =$sum/3;
        if($moyen>=10){
            $is_admin="yes";
        }else{
            $is_admin="not";
        }
        return $is_admin;

    }
    public function moyentrimester( $data){
        $sum=0;
        // dd(count($data));
        // if (count($data) < 1) {

        //     return 0;
        // }
        foreach ($data as $exam){
                $sum+=$exam->grade * $exam->subject->code;
        }
     return  $moyen = $sum/count($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Promotion $promotion)
    {
        if (!Auth::user()->can('school-promotion-list')) {
            toastr()->error(  trans('genirale.no_permission_message'), 'Error');
            return redirect()->back();
        }
        $offset = 0;
        $limit = 10;
        $sort = 'id';
        $order = 'DESC';

        if (isset($_GET['offset']))
        $offset = $_GET['offset'];
        if (isset($_GET['limit']))
        $limit = $_GET['limit'];

        if (isset($_GET['sort']))
        $sort = $_GET['sort'];
        if (isset($_GET['order']))
        $order = $_GET['order'];

        $sql = Promotion::where('school_id',getSchool()->id);
        if (isset($_GET['search']) && !empty($_GET['search'])) {

            $search = $_GET['search'];
            $sql->where('id', 'LIKE', "%$search%")
            ->orwhere('name', 'LIKE', "%$search%");
        }

        if (isset($_GET['session_year']) && !empty($_GET['session_year'])){

            $sql->where('academic_year', $_GET['session_year']);
        }
        if (isset($_GET['section_id']) && !empty($_GET['section_id'])){

            $sql->where('to_section', $_GET['section_id']);
        }

        if (empty($_GET['section_id'])){
            $limit=10;
        }

        $res = $sql->orderBy($sort, $order)->skip($offset)->take($limit)->get();
        $res = $sql->get();

        $bulkData = array();
        $rows = array();
        $tempRow = array();
        $no = 1;
        foreach ($res as $row) {
            $operate = '';
            $operate .= '<a class="btn btn-xs btn-gradient-info btn-rounded btn-icon" href='.route('school.student.show',$row->id). '><i class="fa fa-eye"></i></a>';
            $operate .= '</div></div>&nbsp;&nbsp;';


           $tempRow['id'] = $row->id;
           $tempRow['fullName'] =$row->student->first_name.' '.$row->student->last_name;

          $tempRow['operate'] =$operate;
           $tempRow['from_section_id'] =$row->fromSection->name??'';
           $tempRow['to_section_id'] =$row->toSection->name??'';
           $tempRow['academic_year'] =$row->fromSessionyear->name??'';
           $tempRow['academic_year_new'] =$row->toSessionyear->name??'';
           $rows[] = $tempRow;
        }

        $bulkData['rows'] = $rows;
        return response()->json($bulkData);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Promotion $promotion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Promotion $promotion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promotion $promotion)
    {
        //
    }
}
