<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\Announcement;
use App\Models\Section;
use App\Models\File;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\StudentAcount;
use Illuminate\Http\Request;
use App\Notifications\AnnouncementByAdmin;
use Illuminate\Support\Facades\Notification;
use  App\Models\NotifiAnnouncement;
class AnnouncementController extends Controller
{
    public function index() {
        if (!Auth::user()->can('announcement-list')) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return redirect(route('home'))->withErrors($response);
        }
        
        return view('Admin.announcement.index');
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

        if (!Auth::user()->can('announcement-create')) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return redirect(route('home'))->withErrors($response);
        }
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'data' => 'required',
            'title' => 'required',
        ],[
            'data.required' => 'The Field is Required'
        ]);

        try {
            $users=[];
            if($request->type=="Students"){
            //    $users=Student::all();
               $users=StudentAcount::all();
               foreach($users as $user){
                if($user->token !=null){
                    send_notification($user,$request->title,$request->title,$request->type);
                    send_parent_notification($user->student->parent,$request->title,$request->title,$request->type);
                }
               }
            }
            if($request->type=="Teachers"){
                $users=Teacher::all();
            }
            if($request->type=="Schools"){
                $users=User::where(['model'=>'App\\Models\\Schools','is_admin_school'=>1])->get();
            }
            if($request->type=="Acadimy"){
                $users=User::where(['model'=>'App\\Models\\Acadimy','is_admin_school'=>1])->get();
            }


            $data=$request->all();
            Notification::send($users,new AnnouncementByAdmin($data));
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
        return redirect()->back()->with('success',trans('genirale.data_store_successfully'));
    }



    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        // return $id;
        if (!Auth::user()->can('announcement-show')) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return redirect(route('home'))->withErrors($response);
        }
        $notification= NotifiAnnouncement::find($id);
        DB::table('notifications')->where('id',$id)->update(['read_at'=>now()]);
        $data=json_decode($notification->data)->data;
        return view('Admin.announcement.list',compact('data'));
    }

    public function destroy($id) {
        if (!Auth::user()->can('announcement-delete')) {
            $response = array(
                'error' => true,
                'message' => trans('genirale.no_permission_message')
            );
            return response()->json($response);
        }
        try {
            Announcement::find($id)->delete();
            $response = array(
                'error' => false,
                'message' => trans('genirale.data_delete_successfully')
            );
        } catch (Throwable $e) {
            $response = array(
                'error' => true,
                'message' => trans('genirale.error_occurred')
            );
        }
        return response()->json($response);
    }
}
