<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\SubjectTeacher;
use Illuminate\Http\Request;
use App\Models\Classes;
use App\Models\ClassSection;
use App\Models\Subject;
use App\Models\Section;
use App\Models\Teacher;
use App\Models\Timetable;
use Illuminate\Support\Facades\Auth;
use Mockery\Matcher\Subset;
use Throwable;
class SubjectTeacherController extends Controller
{


    public function index()
    {
        // if (!Auth::user()->can('subject-teacher-list')) {
        //     $response = array(
        //         'message' => trans('no_permission_message')
        //     );
        //     return redirect(route('home'))->withErrors($response);
        // }

        $subjects = Subject::orderBy('id', 'DESC')->get();

        $classes  = Classes::where('grade_id',getSchool()->grade_id)->get();

        $teachers = Teacher::where('school_id',getSchool()->id)->get();

        return view('pages.subject.teacher', compact('classes', 'teachers', 'subjects'));
    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'section_id' => [
                'required',
                'integer',
                'unique:subject_teachers,class_section_id,NULL,id,teacher_id,' . $request->input('teacher_id') . ',school_id,' . getSchool()->id,
            ],
            'subject_id' => [
                'required',
                'integer',
                'unique:subject_teachers,subject_id,NULL,id,class_section_id,' . $request->input('section_id') . ',teacher_id,' . $request->input('teacher_id') . ',school_id,' . getSchool()->id,
            ],
            'teacher_id' => [
                'required',
                'integer',
                'unique:subject_teachers,teacher_id,NULL,id,class_section_id,' . $request->input('section_id') . ',subject_id,' . $request->input('subject_id') . ',school_id,' . getSchool()->id,
            ],
        ]);

        if ($validator->fails()) {
            $response = [
                'error' => true,
                'message' => trans('genirale.error_occurred'),
                'data' => $validator->errors()
            ];
            return redirect()->back()->with('error', $response['message']);
        }

        // If validation passes, continue with your logic

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            // Combine all error messages into a single string
            $errorMessage = implode("\n", $errors);
            $response = [
                'error' => true,
                'message' => $errorMessage,
                'data' => $validator->errors()
            ];
            return redirect()->back()->with('error', $response['message']);
        }



        try {
            $subjectTeacher=new SubjectTeacher();
            $subjectTeacher->class_section_id=$request->section_id;
            $subjectTeacher->subject_id=$request->subject_id;
            $subjectTeacher->teacher_id=$request->teacher_id;
            $subjectTeacher->school_id  = getSchool()->id;
            $subjectTeacher->session_year=getYearNow()->id;
            $subjectTeacher->status=1;
            $subjectTeacher->save();


            $response = [
                'error' => false,
                'message' => trans('genirale.data_store_successfully')
            ];
        } catch (Throwable $e) {
            $response = array(
                'error' => true,
                'message' => trans('genirale.error_occurred'),
                'data' => $e
            );
        }
        return redirect()->back()->with('success',$response['message']);
    }

    public function update(Request $request)
    {

        // if (!Auth::user()->can('subject-teacher-edit')) {
        //     $response = array(
        //         'error' => true,
        //         'message' => trans('no_permission_message')
        //     );
        //     return response()->json($response);
        // }
        $request->validate([
            'class_section_id' => 'required|numeric',
            'subject_id' => 'required|numeric',
            'teacher_id' => 'required',
        ]);

        try {
            $subject_teacher = SubjectTeacher::find($request->id);
            $subject_teacher->class_section_id = $request->section_id;
            $subject_teacher->subject_id = $request->subject_id;
            $subject_teacher->teacher_id = $request->teacher_id;
            $subject_teacher->save();
            $response = [
                'error' => false,
                'message' => trans('genirale.data_update_successfully')
            ];
        } catch (Throwable $e) {
            $response = array(
                'error' => true,
                'message' => trans('genirale.error_occurred'),
                'data' => $e
            );
        }
        return redirect()->back();
    }

    public function show()
    {
        // if (!Auth::user()->can('subject-teacher-list')) {
        //     $response = array(
        //         'error' => true,
        //         'message' => trans('no_permission_message')
        //     );
        //     return response()->json($response);
        // }
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

        $sql = SubjectTeacher::where('school_id',getSchool()->id);
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search = $_GET['search'];
            $sql->where('id', 'LIKE', "%$search%")
                ->orWhereHas('class_section.class', function ($q) use ($search) {

                    $q->where('name', 'LIKE', "%$search%");
                })
                ->orWhereHas('class_section.section', function ($q) use ($search) {

                    $q->where('name', 'LIKE', "%$search%");
                })
                ->orWhereHas('subject', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%$search%");
                })
                ->orWhereHas('teacher.user', function ($q) use ($search) {
                    $q->whereRaw("concat(users.first_name,' ',users.last_name) LIKE '%" . $search . "%'")->orwhere('users.first_name', 'LIKE', "%$search%")->orwhere('users.last_name', 'LIKE', "%$search%");
                });
        }


        $total = $sql->count();

        $sql->orderBy($sort, $order)->skip($offset)->take($limit);
        $res = $sql->get();

        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();
        $no = 1;
        foreach ($res as $row) {

            $operate = '<a class="btn btn-xs btn-gradient-primary btn-rounded btn-icon editdata" data-id=' . $row->id . ' data-url=' . url('subject-teachers') . ' title="Edit" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';
            $operate .= '<a class="btn btn-xs btn-gradient-danger btn-rounded btn-icon deletedata" data-id=' . $row->id . ' data-url=' . url('school/subject-teachers', $row->id) . ' title="Delete"><i class="fa fa-trash"></i></a>';

            $tempRow['id'] = $row->id;
            $tempRow['no'] = $no++;
            $tempRow['class_section_id'] = $row->class_section_id;
            $tempRow['class_section_name'] = $row->section->name ;
            $tempRow['subject_id'] = $row->subject_id;
            $tempRow['subject_name'] = $row->subject->name . ' ( ' .$row->subject->type . ' ) ';
            $tempRow['teacher_id'] = $row->teacher_id;
            $tempRow['teacher_name'] = ($row->teacher) ? ($row->teacher->first_name . ' ' . $row->teacher->last_name) : '';
            $tempRow['operate'] = $operate;
            $rows[] = $tempRow;
        }
        $bulkData['rows'] = $rows;
        return response()->json($bulkData);
    }


    public function edit($id)
    {
        $subject_teacher = SubjectTeacher::find($id);
        return response($subject_teacher);
    }


    public function destroy($id)
    {
        // if (!Auth::user()->can('subject-teacher-delete')) {
        //     $response = array(
        //         'error' => true,
        //         'message' => trans('no_permission_message')
        //     );
        //     return response()->json($response);
        // }

        try {

            $timetables = Timetable::where('subject_teacher_id',$id)->count();
            if($timetables){
                $response = array(
                    'error' => true,
                    'message' => trans('genirale.cannot_delete_beacuse_data_is_associated_with_other_data')
                );
            }else{
                SubjectTeacher::find($id)->delete();
                $response = [
                    'error' => false,
                    'message' => trans('genirale.data_delete_successfully')
                ];
            }
        } catch (Throwable $e) {
            $response = array(
                'error' => true,
                'message' => trans('genirale.error_occurred')
            );
        }
        return response()->json($response);
    }

    public function  getSubjectByClass($id){
        $subjects =Subject::where(['class_id' => $id,'school_id'=>getSchool()->id])->get();
        return response($subjects);
    }
}
