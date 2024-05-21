<?php

namespace App\Http\Controllers\Schools\Student;
use App\Models\MyParent;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentAcount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreStudentsRequest;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;
class StudentController extends Controller
{
    public function create(){
        return view('pages.schools.students.create');
    }
    public function index(){
        return view('pages.schools.students.index');
    }
    public function store(StoreStudentsRequest $request){

        try {
            DB::beginTransaction();

          if($request->has("exist_father")){

            $father_parent=MyParent::find($request->father_gradian_id);

          }else{
            $father_parent = new MyParent();
            $father_parent->username = $request->father_mobile;
            $father_parent->password =Hash::make( str_replace('-', '',$request->father_dob));
            $father_parent->father_first_name = $request->father_last_name;
            $father_parent->father_last_name = $request->father_last_name;
            $father_parent->father_mobile = $request->father_mobile;
            $father_parent->school_id = getSchool()->id;
            $father_parent->father_dob = $request->father_dob;
            $father_parent->father_occupation = $request->father_occupation;
            $father_parent->image = $request->father_last_name;
            $father_parent->status ='0';
            $father_parent->cratedby = Auth::user()->name;
            $father_parent->save();
          }





                $student = new Student();
                $student->grade_id = getSchool()->grade_id;
                $student->section_id = $request->section_id;
                $student->class_id = $request->class_id;
                $student->first_name = $request->first_name;
                $student->last_name = $request->last_name;
                $student->permanent_address = $request->permanent_address;
                $student->current_address = $request->current_address;
                $student->acadimic_id = getAcadimic(getSchool()->academy_id)->id;
                $student->school_id = getSchool()->id;
                $student->gender = $request->gender;
                $student->academic_year = getYearNow()->id;
                $student->date_birth = $request->dob;
                $student->roll_number = getRollNumber($request->section_id)+1;
                $student->blood_group = $request->blood_group;
                $student->parent_id = $father_parent->id;
                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    // made file name with combination of current time
                    $file_name = time() . '-' . $image->getClientOriginalName();
                    //made file path to store in database
                    $file_path = 'students/' . $file_name;
                    //resized image
                    // resizeImage($image);
                    //stored image to storage/public/teachers folder
                    $destinationPath = storage_path('app/public/students');
                    $image->move($destinationPath, $file_name);

                    $student->image = $file_path;

                } else {

                    $student->image = "";
                }
                $student->cratedby = Auth::user()->name;
                $student->status = 1;
                $student->save();


                $studentAcount =new StudentAcount();
                $studentAcount->username=$father_parent->father_mobile.''.$student->roll_number;
                $studentAcount->password=Hash::make(str_replace('-', '', $request->dob));
                $studentAcount->student_acount_id=$student->id;
                $studentAcount->status=1;
                $studentAcount->save();

                DB::commit();
                toastr()->success( trans('genirale.data_store_successfully'), 'Congrats');
                // $pdf = Pdf::loadView('pages.schools.students.inscription');
                // return $pdf->stream('inscription.pdf');
                // return  redirect()->route('school.student.create');
                return back();
        } catch (\Exception $e) {
            // If an exception occurs, rollback the transaction
            DB::rollBack();

            // Handle or log the exception
            return back()->withError(['error' => 'Error: ' . $e->getMessage()]);
        }
    }
    public function update(Request $request){
         $request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'gender'     =>'required',
            'mobile'     => 'regex:/^([0-9\s\-\+\(\)]*)$/',
            'image'      => 'nullable|mimes:jpeg,png,jpg|image|max:2048',
            'blood_group'=> 'required',
            'section_id'       => 'required',
            'current_address'  => 'required',
            'permanent_address'=> 'required',
        ]);
        try {

            $student =  Student::find($request->student_id);
            $father_parent=MyParent::find($student->parent_id);
            $student->grade_id = getSchool()->grade_id;
            $student->section_id = $request->section_id;
            $student->class_id = $request->class_id;
            $student->first_name = $request->first_name;
            $student->last_name = $request->last_name;
            $student->permanent_address = $request->permanent_address;
            $student->current_address = $request->current_address;
            $student->acadimic_id = getAcadimic(getSchool()->academy_id)->id;
            $student->school_id = getSchool()->id;
            $student->gender = $request->gender;
            $student->academic_year = getYearNow()->id;
            $student->date_birth = $request->dob;
            $student->roll_number = getRollNumber($request->section_id)+1;
            $student->blood_group = $request->blood_group;
            $student->parent_id = $father_parent->id;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                // made file name with combination of current time
                $file_name = time() . '-' . $image->getClientOriginalName();
                //made file path to store in database
                $file_path = 'students/' . $file_name;
                //resized image
                // resizeImage($image);
                //stored image to storage/public/teachers folder
                $destinationPath = storage_path('app/public/students');
                $image->move($destinationPath, $file_name);

                $student->image = $file_path;

            } else {

                $student->image = "";
            }
            $student->cratedby = Auth::user()->name;
            $student->status = 1;
            $student->save();
            toastr()->success( trans('genirale.data_delete_successfully'), 'Congrats');
            return  redirect()->route('school.studentts.index');
        } catch (\Exception $e) {

            DB::rollBack();

            return back()->withError(['error' => 'Error: ' . $e->getMessage()]);
        }
    }
    public function getList(){
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

        $sql = Student::InStudent()->where('school_id',getSchool()->id);
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search = $_GET['search'];
            $sql->where('id', 'LIKE', "%$search%")
            ->orwhere('name', 'LIKE', "%$search%");
        }

        $res = $sql->orderBy($sort, $order)->skip($offset)->take($limit)->get();
        $res = $sql->get();

        $bulkData = array();
        $rows = array();
        $tempRow = array();
        $no = 1;
        foreach ($res as $row) {
            $operate = '';
            $operate .= '<a class="btn btn-xs btn-gradient-primary btn-rounded btn-icon "  title="Edit"  href='. route('school.student.edit', $row->id).'><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';
            $operate .= '<a class="btn btn-xs btn-gradient-danger btn-rounded btn-icon deletedata" data-id=' . $row->id . ' data-url=' . route('school.studentts.destroy', $row->id). ' title="Delete"><i class="fa fa-trash"></i></a>';
            $operate .= '<a href=' . route('school.inscription.pdf', $row->id) . ' class="btn btn-xs btn-gradient-info btn-rounded btn-icon generate-paid-fees-pdf" target="_blank" data-id= title="' . trans('generate_pdf') . ' ' . trans('fees') . '"><i class="fa fa-file-pdf-o"></i></a>&nbsp;&nbsp;';

           $tempRow['id'] = $row->id;
           $tempRow['fullName'] =$row->first_name.' '.$row->last_name;
        //    $tempRow['last_name'] =$row->last_name;
           $tempRow['gender'] =$row->gender;
           $tempRow['date_birth'] =$row->date_birth;
           $tempRow['roll_number'] =$row->roll_number;
           $tempRow['blood_group'] = $row->blood_group;
           $tempRow['parent_id'] = $row->parent->father_first_name.' '. $row->parent->father_last_name;
           $tempRow['operate'] =$operate;
           $tempRow['section_id'] =$row->section->name;
           $rows[] = $tempRow;
        }

        $bulkData['rows'] = $rows;
        return response()->json($bulkData);
    }
    public function edit(Student $id){
        $student =Student::Instudent()->where('id',$id->id)->first();
        return view('pages.schools.students.edit',compact('student'));
    }
    public function destroy($id){

        try {


            $student = Student::find($id);
            // if (Storage::disk('students')->exists($student->image)) {
            //     Storage::disk('students')->delete($student->image);
            // }
            $student->delete();

            $response = [
                'error' => false,
                'message' => trans('genirale.data_delete_successfully')
            ];

     } catch (Throwable $e) {
        $response = array(
            'error' => true,
            'message' => trans('genirale.error_occurred')
        );
        }
        return response()->json($response);
    }

    public function getPdf($id){
        $student =Student::find($id);

        $pdf = Pdf::loadView('pages.schools.students.inscription',compact('student'));
        return $pdf->stream('inscription.pdf');
    }

}
