<?php

namespace App\Http\Controllers\Schools;
use App\Models\Student;
use App\Models\Teacher;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolAnnoucement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AnnouncementByAdmin;
class SchoolAnnoucementController extends Controller
{
    public function index() {
        if (!Auth::user()->can('school-announcement-index')) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return redirect(route('school.school.home'))->withErrors($response);
        }
        return view('pages.schools.announcement.index');
    }

    public function store(Request $request) {
        if (!Auth::user()->can('school-announcement-create')) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return redirect(route('school.school.home'))->withErrors($response);
        }

        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'description' => 'required',
            'title' => 'required',
        ],[
            'description.required' => 'The Field is Required',
            'title.required' => 'The Field is Required'
        ]);

        try {

            $users=[];
            if($request->type=="Students"){
                SchoolAnnoucement::create([
                    'title' => $request->title,
                    'description' => $request->description,
                    'model'=>'App\Models\School',
                    'model_id'=>getSchool()->id,
                   'session_year'=>getYearNow()->id,
                   'school_id'=>getSchool()->id,
                ]);


               $users=Student::where('school_id',getSchool()->id)->get();
               foreach($users as $user){
                if($user->studentAccount->token !=null){
                    send_notification($user->studentAccount,$request->title,$request->description,$request->type);
                    send_parent_notification($user->parent,$request->title,$request->description,$request->type);
                }
               }
            }
            if($request->type=="Teachers"){
                SchoolAnnoucement::create([
                    'title' => $request->title,
                    'description' => $request->description,
                    'model'=>'App\Models\Teacher',
                    'model_id'=>Auth::guard('school')->user(),
                   'session_year'=>getYearNow()->id,
                   'school_id'=>getSchool()->id,
                ]);
                $users=Teacher::where('school_id',getSchool()->id)->get();
            }



            $data=$request->all();
            $data['data']=$request->description;
            Notification::send($users,new AnnouncementByAdmin($data));
            $response = array(
                'error' => false,
                'message' => trans('genirale.data_store_successfully')
            );
        } catch (\Throwable $e) {
            toastr()->error( trans('genirale.error_occurred'), 'Error');
            return redirect()->back();
        }
        toastr()->success( trans('genirale.data_store_successfully'), 'Congrats');
        return redirect()->back();
    }
}
