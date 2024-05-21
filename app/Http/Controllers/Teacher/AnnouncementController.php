<?php

namespace App\Http\Controllers\Teacher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Announcement;
use App\Models\ClassRoom;
use App\Models\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class AnnouncementController extends Controller
{
    public function index() {
        // if (!Auth::user()->can('announcement-list')) {
        //     $response = array(
        //         'message' => trans('no_permission_message')
        //     );
        //     return redirect(route('home'))->withErrors($response);
        // }
        // $class_section = ClassSection::SubjectTeacher()->with('class.medium', 'section')->get();
        return view('pages.teachers.announcement.index');
    }

    public function getAssignData(Request $request) {
        $data = $request->data;
        $class_id = $request->class_id;
        if ($data == 'class_section' && $class_id != '') {
            $info = ClassSubject::where('class_id', $class_id)->with('subject')->get();
        } elseif ($data == 'class') {
            $info = ClassSchool::get();
        } else {
            $info = '';
        }
        return response()->json($info);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        // return $request;
        // if (!Auth::user()->can('announcement-create')) {
        //     $response = array(
        //         'error' => true,
        //         'message' => trans('no_permission_message')
        //     );
        //     return response()->json($response);
        // }
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'set_data' => 'required'
        ],[
            'set_data.required' => 'The Assign To Field is Required'
        ]);
        if ($validator->fails()) {
            $response = array(
                'error' => true,
                'message' => $validator->errors()->first()
            );
            return response()->json($response);
        }
        try {
            // $user = array();
            // $data = getSettings('session_year');
            // if (!empty($request->get_data)) {
            //     $getdata = count($request->get_data);
            // } else {
            //     $getdata = 1;
            // }
            // for ($i = 0; $i < $getdata; $i++) {
                $announcement = new Announcement();
                $announcement->title = $request->title;
                $announcement->description = $request->description;
                $announcement->section_id = $request->class_section_id;
                $announcement->subject_id = $request->subject_id;
                if($request->has('class_section_id')){
                    $class=ClassRoom::find( $request->class_section_id);
                    $announcement->table()->associate($class);
                }

                $announcement->description = $request->description;
                $announcement->session_year = getYearNow()->id;
                $announcement->school_id = getSchool()->id;
                $announcement->save();
                // send_notification($user, $title, $body, $type);
                if ($request->hasFile('file')) {
                    foreach ($request->file as $file_upload) {
                        $file = new File();
                        $file->file_name = $file_upload->getClientOriginalName();
                        $file->type = 1;
                        $file->file_url = $file_upload->store('announcement', 'public');
                        $file->modal()->associate($announcement);
                        $file->save();
                    }
                }
            // }
            $response = array(
                'error' => false,
                'message' => trans('genirale.data_store_successfully')
            );
        } catch (\Throwable $e) {
            $response = array(
                'error' => true,
                'message' => trans('genirale.error_occurred')
            );
        }
        return response()->json($response);
    }

    public function update(Request $request) {
        if (!Auth::user()->can('announcement-edit')) {
            $response = array(
                'error' => true,
                'message' => trans('no_permission_message')
            );
            return response()->json($response);
        }
        $request->validate([
            'title' => 'required',
            'set_data' => 'required'
        ],  [
            'set_data.required' => 'The Assign To Field is required.'
        ]);
        try {
            $user = array();
            $data = getSettings('session_year');
            if(Auth::user()->teacher){
                $teacher_id = Auth::user()->teacher->id;
            }
            $announcement = Announcement::find($request->id);
            $announcement->title = $request->title;
            $announcement->description = $request->description;
            $announcement->session_year_id = $data['session_year'];
            if (!empty($request->set_data)) {
                if ($request->set_data == 'class_section') {
                    $subject_teacher_id = SubjectTeacher::select('id')->where(['class_section_id' => $request->class_section_id, 'subject_id' => $request->get_data,'teacher_id'=>$teacher_id])->get()->pluck('id');
                    $subject_name = SubjectTeacher::where(['class_section_id' => $request->class_section_id, 'subject_id' => $request->get_data,'teacher_id'=>$teacher_id])->with('subject')->get();
                    if (count($subject_teacher_id) != 0) {
                        for ($j = 0; $j < count($subject_teacher_id); $j++) {
                            $subject_teacher = SubjectTeacher::find($subject_teacher_id[$j]);
                            $announcement->table()->associate($subject_teacher);
                            $user = Students::select('user_id')->where('class_section_id', $request->class_section_id)->get()->pluck('user_id');
                        }
                        $title = 'Update announcement in ' . $subject_name[0]->subject->name;
                        $body = $request->title;
                    }
                }
                if ($request->set_data == 'class') {
                    $class = ClassSchool::find($request->get_data);
                    $announcement->table()->associate($class);
                    $get_class = ClassSection::select('id')->where('class_id', $request->get_data)->get()->pluck('id');
                    $user = Students::select('user_id')->where('class_section_id', $get_class)->get()->pluck('user_id');
                    $title = $request->title;
                    $body = $request->description;
                }
                if ($request->set_data == 'general') {
                    $announcement->table_id = null;
                    $announcement->table_type = "";
                    $user = Students::select('user_id')->get()->pluck('user_id');
                    $title = 'Noticeboard updated';
                    $body = $request->title;
                }
            }
            $type = $request->set_data;
            $announcement->save();
            send_notification($user, $title, $body, $type);
            send_parent_notification($user->parent,$request->title,$request->description,$request->type);
            if ($request->hasFile('file')) {
                foreach ($request->file as $file_upload) {
                    $file = new File();
                    $file->file_name = $file_upload->getClientOriginalName();
                    $file->type = 1;
                    $file->file_url = $file_upload->store('announcement', 'public');
                    $file->modal()->associate($announcement);
                    $file->save();
                }
            }
            $response = [
                'error' => false,
                'message' => trans('data_update_successfully'),
            ];
        } catch (Throwable $e) {
            $response = [
                'error' => true,
                'message' => trans('error_occurred'),
            ];
        }
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show() {
        // if (!Auth::user()->can('announcement-list')) {
        //     $response = array(
        //         'message' => trans('no_permission_message')
        //     );
        //     return response()->json($response);
        // }
        // $announcement=Announcement::get();
        // return view('announcement.list',compact('announcement'));
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
        $sql = Announcement::with('table', 'file');
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search = $_GET['search'];
            $sql->where('id', 'LIKE', "%$search%")
                ->orwhere('title', 'LIKE', "%$search%")
                ->orwhere('description', 'LIKE', "%$search%");
        }
        $total = $sql->count();
        $sql->orderBy($sort, $order)->skip($offset)->take($limit);
        $res = $sql->get();
        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();
        $no = 1;
        $user = Auth::user();
        foreach ($res as $row) {
            $operate = '';
                $operate .= '<a class="btn btn-xs btn-gradient-primary btn-rounded btn-icon editdata" data-id="' . $row->id . '"  title="Edit" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';
                $operate .= '<a class="btn btn-xs btn-gradient-danger btn-rounded btn-icon deletedata" data-id="' . $row->id . '" data-url="' . route('teacher.announcement.destroy', $row->id) . '" title="Delete"><i class="fa fa-trash"></i></a>';


            $tempRow['id'] = $row->id;
            $tempRow['no'] = $no++;
            $tempRow['title'] = $row->title;
            $tempRow['description'] = $row->description;
            $tempRow['type'] = $row->table_type;
            if ($tempRow['type'] == "App\\Models\\Section") {
                $assign = 'class_section';

                // $class =  $row->table->classe->name . ' - ' . $row->table->name;
                // $class1 = $class;
            }

            if ($tempRow['type'] == "") {
                $assign = 'general';
                $class = trans("general");
                // $class1 = $class;
            }
            // $tempRow['assign'] = $assign;
            // $tempRow['assign_to'] = $class;
            // $tempRow['assignto'] = $class1;
            $tempRow['get_data'] = $row->table_id;
            $tempRow['file'] = $row->file;
            $tempRow['operate'] = $operate;
            $rows[] = $tempRow;
        }
        $bulkData['rows'] = $rows;
        return response()->json($bulkData);
    }

    public function destroy($id) {
        // if (!Auth::user()->can('announcement-delete')) {
        //     $response = array(
        //         'error' => true,
        //         'message' => trans('no_permission_message')
        //     );
        //     return response()->json($response);
        // }
        try {
            Announcement::find($id)->delete();
            $response = array(
                'error' => false,
                'message' => trans('data_delete_successfully')
            );
        } catch (Throwable $e) {
            $response = array(
                'error' => true,
                'message' => trans('error_occurred')
            );
        }
        return response()->json($response);
    }
}
