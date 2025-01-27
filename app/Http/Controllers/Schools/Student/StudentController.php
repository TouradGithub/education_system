<?php

namespace App\Http\Controllers\Schools\Student;
use App\Models\MyParent;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;
use Milon\Barcode\DNS2D;


use Illuminate\Support\Facades\Auth;
use App\Models\StudentAcount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreStudentsRequest;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ClassRoom;
use App\Models\SchoolAnnoucement;
class StudentController extends Controller
{
    public function create(){
        if (!Auth::user()->can('school-students-create')) {
            toastr()->error(  trans('genirale.no_permission_message'), 'Error');
            return redirect()->back();
        }
        $sectionSchool = ClassRoom::where('school_id',getSchool()->id)->count();
        if($sectionSchool==0){
            return redirect()->route('school.sections.index')->with('Error',"No Sections Found");
        }
        return view('pages.schools.students.create');
    }
    public function index(){
        if (!Auth::user()->can('school-students-index')) {
            toastr()->error(  trans('genirale.no_permission_message'), 'Error');
            return redirect()->back();
        }
        return view('pages.schools.students.index');
    }
    public function store(StoreStudentsRequest $request){
        if (!Auth::user()->can('school-students-create')) {
            toastr()->error(  trans('genirale.no_permission_message'), 'Error');
            return redirect()->back();
        }
        try {
            DB::beginTransaction();

          if($request->has("exist_father")){

            $father_parent=MyParent::find($request->father_gradian_id);

          }else{
            $father_parent = new MyParent();
            $father_parent->username = $request->father_mobile;
            $father_parent->password =Hash::make( str_replace('-', '',$request->father_dob));
            $father_parent->father_first_name = $request->father_first_name;
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



          $qr_code = mt_rand(1000,999999999);
          if($this->studentCodeExists($qr_code)){
              $qr_code = mt_rand(1000,999999999);
          }

                $student = new Student();
                $student->grade_id = getSchool()->grade_id;
                $student->section_id = $request->section_id;
                $student->class_id = $request->class_id;
                $student->qr_code = $qr_code;
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
                return back();
        } catch (\Exception $e) {
            // If an exception occurs, rollback the transaction
            DB::rollBack();

            // Handle or log the exception
            return back()->withError(['error' => 'Error: ' . $e->getMessage()]);
        }
    }
    public function update(Request $request){
        if (!Auth::user()->can('school-students-edit')) {
            toastr()->error(  trans('genirale.no_permission_message'), 'Error');
            return redirect()->back();
        }
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
    public function studentCodeExists($qr_code){
        return Student::where('qr_code',$qr_code)->exists();
    }
    public function getList(){
        if (!Auth::user()->can('school-students-index')) {
            toastr()->error(trans('genirale.no_permission_message'), 'Error');
            return redirect()->back();
        }
        $offset = 0;
        $limit = 10;
        $sort = 'id';
        $order = 'DESC';

        if (isset($_GET['offset'])) {
            $offset = $_GET['offset'];
        }
        if (isset($_GET['limit'])) {
            $limit = $_GET['limit'];
        }

        if (isset($_GET['sort'])) {
            $sort = $_GET['sort'];
        }
        if (isset($_GET['order'])) {
            $order = $_GET['order'];
        }

        $sql = Student::InStudent()->where('school_id', getSchool()->id);
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search = $_GET['search'];
            $sql->where('id', 'LIKE', "%$search%")
                ->orWhere('name', 'LIKE', "%$search%");
        }

        if (isset($_GET['section_id']) && !empty($_GET['section_id'])) {
            $sql->where('section_id', $_GET['section_id']);
        }

        if (empty($_GET['section_id'])) {
            $limit = 10;
        }

        $res = $sql->orderBy($sort, $order)->skip($offset)->take($limit)->get();
        $res = $sql->get();

        $bulkData = array();
        $rows = array();
        $tempRow = array();
        $no = 1;

        // Instantiate DNS2D class
        $d = new DNS2D();

        foreach ($res as $row) {
            $operate = '';
            $operate = '<div class="dropdown"><button class="btn btn-xs btn-gradient-success btn-rounded btn-icon dropdown-toggle" type="button" data-toggle="dropdown">Actions</button><div class="dropdown-menu">';
            $operate .= '<a href=' . route('school.student.idcard', $row->id) . ' class="btn btn-xs btn-gradient-info btn-rounded btn-icon generate-paid-fees-pdf" target="_blank" data-id= title=" ID CARD  ' . trans('fees') . '">ID CARD</a>&nbsp;&nbsp;';

            if (Auth::user()->can('school-students-inscription')) {
                $operate .= '<a href=' . route('school.student.schow.inscription', $row->id) . ' class="btn btn-xs btn-gradient-info btn-rounded btn-icon generate-paid-fees-pdf" target="_blank" data-id= title="' . trans('generate_pdf') . ' ' . trans('fees') . '"><i class="fa fa-file-pdf-o"></i></a>&nbsp;&nbsp;';
            }

            if (Auth::user()->can('school-students-inscription')) {
                $operate .= '<a href=' . route('school.student.schow.inscription', $row->id) . ' class="btn btn-xs btn-gradient-info btn-rounded btn-icon generate-paid-fees-pdf" target="_blank" data-id= title="' . trans('generate_pdf') . ' ' . trans('fees') . '"><i class="fa fa-file-pdf-o"></i></a>&nbsp;&nbsp;';
            }

            if (Auth::user()->can('school-students-delete')) {
                $operate .= '<a class="btn btn-xs btn-gradient-danger btn-rounded btn-icon deletedata" data-id=' . $row->id . ' data-url=' . route('school.studentts.destroy', $row->id) . ' title="Delete"><i class="fa fa-trash"></i></a>';
            }

            if (Auth::user()->can('school-students-edit')) {
                $operate .= '<a class="btn btn-xs btn-gradient-primary btn-rounded btn-icon "  title="Edit"  href=' . route('school.student.edit', $row->id) . '><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';
            }

            if (Auth::user()->can('school-students-show')) {
                $operate .= '<a class="btn btn-xs btn-gradient-info btn-rounded btn-icon" href=' . route('school.student.show', $row->id) . '><i class="fa fa-eye"></i></a>';
            }

            $operate .= '</div></div>&nbsp;&nbsp;';

            $tempRow['id'] = $row->id;
            $tempRow['fullName'] = $row->first_name . ' ' . $row->last_name;
            $tempRow['gender'] = $row->gender;
            $tempRow['date_birth'] = $row->date_birth;
            $tempRow['roll_number'] = $row->roll_number;
            // $code =$row->qr_code;
            $tempRow['qr_code'] =isset($row->qr_code) &&$row->qr_code!=null? $d->getBarcodeHTML($row->qr_code, "QRCODE"):"No Qr Bar";
            $tempRow['blood_group'] = $row->blood_group;
            $tempRow['parent_id'] = isset($row->parent) && $row->parent != null ? $row->parent->father_first_name . ' ' . $row->parent->father_last_name : '';
            $tempRow['operate'] = $operate;
            $tempRow['section_id'] = $row->section->name ?? '';
            $rows[] = $tempRow;
        }

        $bulkData['rows'] = $rows;

        return response()->json($bulkData);
    }

    public function edit(Student $id){
        if (!Auth::user()->can('school-students-edit')) {
            toastr()->error(  trans('genirale.no_permission_message'), 'Error');
            return redirect()->back();
        }
        $student =Student::Instudent()->where('id',$id->id)->first();
        return view('pages.schools.students.edit',compact('student'));
    }

    public function show(Student $id){
        if (!Auth::user()->can('school-students-show')) {
            toastr()->error(  trans('genirale.no_permission_message'), 'Error');
            return redirect()->back();
        }
         $student =Student::find($id->id);
        return view('pages.schools.students.show',compact('student'));
    }
    public function inscription(Student $id){
        if (!Auth::user()->can('school-students-inscription')) {
            toastr()->error(  trans('genirale.no_permission_message'), 'Error');
            return redirect()->back();
        }

        $student =Student::find($id->id);

        $pdf = Pdf::loadView('pages.schools.students.inscription',compact('student'));
        return $pdf->stream('inscription.pdf');
    }
    public function destroy($id){

        if (!Auth::user()->can('school-students-delete')) {
            toastr()->error(  trans('genirale.no_permission_message'), 'Error');
            return redirect()->back();
        }
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

    public function sendMessage(Request $request){
        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'title' => 'required',
            'student_id' => 'required',
        ],[
            'description.required' => 'The Field is Required',
            'student_id.required'  => 'The Field is Required',
            'title.required'       => 'The Field is Required',
        ]);
        if ($validator->fails()) {
            $response = array(
                'error' => true,
                'message' => $validator->errors()->first()
            );
            return response()->json($response);
        }
        try {
            $student =Student::find($request->student_id);
            SchoolAnnoucement::create([
                'title' => $request->title,
                'description' => $request->description,
                'model'=>'App\Models\Student',
                'model_id'=>$student->id,
               'session_year'=>getYearNow()->id,
               'school_id'=>getSchool()->id,
            ]);
            send_notification($student->studentAccount,$request->title,$request->description,"Announce");
            send_parent_notification($student->parent,$request->title,$request->description,"Announce");

            $response = [
                'error' => false,
                'message' => trans('genirale.data_store_successfully')
            ];
        } catch (\Throwable $th) {
            $response = [
                'error' => true,
                'message' => trans('genirale.error_occurred')
            ];
        }
        return response()->json($response);

    }

    public function genratePassword($id){
        try {
            $student =Student::find($id);
            $parent = MyParent::find($student->parent_id);
            $parent->username = $parent->father_mobile;
            $parent->password = Hash::make( str_replace('-', '',$parent->father_dob));
            $parent->save();
            toastr()->success( trans('genirale.data_store_successfully'), 'Congrats');
            return back();
        } catch (\Throwable $th) {
            toastr()->error( trans('genirale.error_occurred'), 'Error');
            return back();
        }


    }

    public function getIdCardPage($id){
        $student =Student::find($id);
        return view('pages.schools.students.id_card',compact('student'));
    }

}

