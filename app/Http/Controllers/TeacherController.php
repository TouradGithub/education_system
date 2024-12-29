<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
// use App\Models\ClassSection;
// use App\Models\SubjectTeacher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\SubjectTeacher;
class TeacherController extends Controller
{

    public function index()
    {
        if (!Auth::user()->can('school-teachers-index') || !Auth::user()->can('school-teachers-create')) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return redirect(route('home'))->withErrors($response);
        }
        return view('pages.schools.teacher.index');
    }


    public function store(Request $request)
    {
        if (!Auth::user()->can('school-teachers-create') ) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return response()->json($response);
        }
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'email' => 'required|email|unique:teachers,email,NULL,id,deleted_at,NULL',
            'mobile' => 'required|digits:8',
            'dob' => 'required|date',
            'qualification' => 'required',
            'current_address' => 'required',
            'permanent_address' => 'required',
        ]);
        if ($validator->fails()) {
            $response = array(
                'error' => true,
                'message' => $validator->errors()->first()
            );
            return response()->json($response);
        }
        try {
            // check if email exists in deleted_at records
            // $check_teacher = Teacher::where('email',$request->email)->onlyTrashed();

                $teacher = new Teacher();

                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    // made file name with combination of current time
                    $file_name = time() . '-' . $image->getClientOriginalName();
                    //made file path to store in database
                    $file_path = 'teachers/' . $file_name;
                    //resized image
                    // resizeImage($image);
                    //stored image to storage/public/teachers folder
                    $destinationPath = storage_path('app/public/teachers');
                    $image->move($destinationPath, $file_name);

                    $teacher->image = $file_path;

                } else {

                    $teacher->image = "";
                }
                $teacher_plain_text_password = str_replace('-', '', date('d-m-Y', strtotime($request->dob)));
                $teacher->password = Hash::make($teacher_plain_text_password);
                $teacher->first_name = $request->first_name;
                $teacher->last_name = $request->last_name;
                $teacher->gender = $request->gender;
                $teacher->current_address = $request->current_address;
                $teacher->permanent_address = $request->permanent_address;
                $teacher->email = $request->email;
                $teacher->school_id = getSchool()->id;
                $teacher->qualification = $request->qualification;
                $teacher->mobile = $request->mobile;
                $teacher->dob = date('Y-m-d', strtotime($request->dob));
                $teacher->save();




            $response = [
                'error' => false,
                'message' => trans('data_store_successfully')
            ];
        } catch (Throwable $e) {
            $response = array(
                'error' => true,
                'message' => trans('error_occurred'),
                'data' => $e
            );
        }
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        if (!Auth::user()->can('school-teachers-index')) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return response()->json($response);
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

        $sql = Teacher::where('school_id',getSchool()->id);
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search = $_GET['search'];
            $sql->where('id', 'LIKE', "%$search%")
                ->orwhere('teachers', function ($q) use ($search) {
                    $q->where('first_name', 'LIKE', "%$search%")
                        ->orwhere('last_name', 'LIKE', "%$search%")
                        ->orwhere('gender', 'LIKE', "%$search%")
                        ->orwhere('email', 'LIKE', "%$search%")
                        ->orwhere('dob', 'LIKE', "%" . date('Y-m-d', strtotime($search)) . "%")
                        ->orwhere('qualification', 'LIKE', "%$search%")
                        ->orwhere('current_address', 'LIKE', "%$search%")
                        ->orwhere('permanent_address', 'LIKE', "%$search%");
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
            $operate = '';
            if (Auth::user()->can('school-teachers-edit') ) {
                $operate = '<a class="btn btn-xs btn-gradient-primary btn-rounded btn-icon editdata" data-id=' . $row->id . ' data-url=' . url('school/teachers') . ' title="Edit" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';

            }

            if (Auth::user()->can('school-teachers-delete') ) {
                $operate .= '<a class="btn btn-xs btn-gradient-danger btn-rounded btn-icon deletedata" data-id=' . $row->id . ' data-user_id=' . $row->id . ' data-url=' . url('school/teachers', $row->id) . ' title="Delete"><i class="fa fa-trash"></i></a>';

            }


            $tempRow['id'] = $row->id;
            $tempRow['no'] = $no++;
            $tempRow['first_name'] = $row->first_name;
            $tempRow['last_name'] = $row->last_name;
            $tempRow['gender'] = $row->gender;
            $tempRow['current_address'] = $row->current_address;
            $tempRow['permanent_address'] = $row->permanent_address;
            $tempRow['email'] = $row->email;
            $tempRow['dob'] = date("d-m-y", strtotime($row->dob));
            $tempRow['mobile'] = $row->mobile;
            $tempRow['image'] = $row->image==null? asset('section/assets/images/team/01.jpg'): url(Storage::url($row->image));
            $tempRow['qualification'] = $row->qualification;

            $tempRow['operate'] = $operate;
            $rows[] = $tempRow;
        }

        $bulkData['rows'] = $rows;
        return response()->json($bulkData);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $teacher = Teacher::find($id);
        return response($teacher);
    }


    public function update(Request $request)
    {
        if (!Auth::user()->can('school-teachers-edit')) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return response()->json($response);
        }
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'email' => 'required',
            'mobile' => 'required|digits:8',
            'dob' => 'required|date',
            'qualification' => 'required',
            'current_address' => 'required',
            'permanent_address' => 'required',
        ]);
        if ($validator->fails()) {
            $response = array(
                'error' => true,
                'message' => $validator->errors()->first()
            );
            return response()->json($response);
        }
        try {
            $teacher=Teacher::find($request->id);
            if ($request->hasFile('image')) {
                if (Storage::exists($request->image)) {
                    Storage::delete($teacher->image);
                }
                $image = $request->file('image');
                // made file name with combination of current time
                $file_name = time() . '-' . $image->getClientOriginalName();
                //made file path to store in database
                $file_path = 'teachers/' . $file_name;
                //resized image
                //stored image to storage/public/teachers folder
                $destinationPath = storage_path('app/public/teachers');
                $image->move($destinationPath, $file_name);

                $teacher->image = $file_path;
            }
            $teacher->first_name = $request->first_name;
            $teacher->last_name = $request->last_name;
            $teacher->gender = $request->gender;
            $teacher->current_address = $request->current_address;
            $teacher->permanent_address = $request->permanent_address;
            $teacher->email = $request->email;
            $teacher->mobile = $request->mobile;
            $teacher->dob = date('Y-m-d', strtotime($request->dob));
            $teacher->save();




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
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Auth::user()->can('school-teachers-delete')) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return response()->json($response);
        }
        try {

            $timetables = SubjectTeacher::where(['teacher_id'=>$id,'school_id'=>getSchool()->id])->count();
            if($timetables){
                $response = array(
                    'error' => true,
                    'message' => trans('genirale.cannot_delete_beacuse_data_is_associated_with_other_data')
                );
            }else{

                $teacher = Teacher::find($id);


                if (Storage::disk('public')->exists($teacher->image)) {
                    Storage::disk('public')->delete($teacher->image);
                }
                $teacher->delete();

                $response = [
                    'error' => false,
                    'message' => trans('genirale.data_delete_successfully')
                ];
            }



        } catch (Throwable $e) {
            $response = array(
                'error' => true,
                'message' => trans('error_occurred')
            );
        }
        return response()->json($response);
    }
}
