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
        // if (!Auth::user()->can('announcement-list')) {
        //     $response = array(
        //         'message' => trans('no_permission_message')
        //     );
        //     return redirect(route('home'))->withErrors($response);
        // }
        // $class_section = ClassSection::SubjectTeacher()->with('class.medium', 'section')->get();
        return view('pages.schools.announcement.index');
    }

    public function store(Request $request) {


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
                    'model'=>'App\Models\Student',
                    'model_id'=>Auth::guard('web')->user()->id,
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
