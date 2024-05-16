<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Trimester;
use App\Models\Schools;
use App\Models\Student;
use App\Models\StudentAcount;
use App\Models\SubjectTeacher;
use Carbon\Carbon;
use App\Models\SessionYear;
use App\Models\Attendance;
use App\Models\ClassScraping;
use App\Models\SchoolAnnoucement;

class StudentApiController extends Controller
{


    public function logout(Request $request){
        try {
            auth()->user()->tokens()->delete();

        } catch (\Exception $e) {
            $response = array(
                'message' => trans('error_occurred'),
                'code' => 103,
            );
            return response()->json($response, 500);
        }
    }
    public function section(Request $request){
        try {
        $class = auth()->user()->student->section->classe;
                $section = auth()->user()->student->section;
            $response = array(

                'code'    => 100,
                'data'=>[
                    'section' => $section,
                ]
            );
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $response = array(
                'error'   => true,
                'message' => trans('error_occurred'),
                'code'    => 103,
            );
            return response()->json($response, 500);
        }
    }
    public function getTimetable(Request $request){
        try {
        $timeTable = auth()->user()->student->section->timeTable;
                // $section = auth()->user()->student->section;
            $response = array(

                'code'    => 100,
                'data'=>[
                    'timeTable' => $timeTable,
                ]
            );
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $response = array(
                'error'   => true,
                'message' => trans('error_occurred'),
                'code'    => 103,
            );
            return response()->json($response, 500);
        }
    }
    public function getExams(Request $request){
        try {
        $exams = auth()->user()->student->exams;
            $response = array(

                'code'    => 100,
                'data'=>[
                    'exams' => $exams,
                ]
            );
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $response = array(
                'error'   => true,
                'message' => trans('error_occurred'),
                'code'    => 103,
            );
            return response()->json($response, 500);
        }
    }

    public function getTests(Request $request){
        try {

        $tests = auth()->user()->student->tests;
                // $section = auth()->user()->student->section;
            $response = array(

                'code'    => 100,
                'data'=>[

                    'tests' => $tests,
                ]
            );
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $response = array(
                'error'   => true,
                'message' => trans('error_occurred'),
                'code'    => 103,
            );
            return response()->json($response, 500);
        }
    }

    public function getLessons(Request $request){
        try {

        $lessons = auth()->user()->student->section->lessons;
                // $section = auth()->user()->student->section;
            $response = array(

                'code'    => 100,
                'data'=>[

                    'lessons' => $lessons,
                ]
            );
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $response = array(
                'error'   => true,
                'message' => trans('error_occurred'),
                'code'    => 103,
            );
            return response()->json($response, 500);
        }
    }
    public function getTrimesters(Request $request){
        try {

         $trimester=   Trimester::all();
                // $section = auth()->user()->student->section;
            $response = array(

                'code'    => 100,
                'data'=>[

                    'trimesters' => $trimester,
                ]
            );
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $response = array(
                'error'   => true,
                'message' => trans('error_occurred'),
                'code'    => 103,
            );
            return response()->json($response, 500);
        }
    }

    public function studentInfo(Request $request){
        try {
        $student = auth()->user()->student;

            $response = array(

                'code'    => 100,
                'data'=>[
                    'studentInfo' => $student,
                ]
            );
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $response = array(
                'error'   => true,
                'message' => trans('error_occurred'),
                'code'    => 103,
            );
            return response()->json($response, 500);
        }
    }
    public function studentAccount(Request $request){
        try {
        $student = auth()->user();

            $response = array(

                'code'    => 100,
                'data'=>[
                    'studentAccount' => $student,
                ]
            );
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $response = array(
                'error'   => true,
                'message' => trans('error_occurred'),
                'code'    => 103,
            );
            return response()->json($response, 500);
        }
    }
    public function getSchool(){
        return  Schools::find(auth()->user()->student->school_id);
    }
    public function getYearNow(){
        return  SessionYear::find(auth()->user()->student->academic_year);
    }
    public function studentSubject(Request $request){
        try {

            $subjects=   SubjectTeacher::where([
                'class_section_id'=>auth()->user()->student->section->id,
                'school_id'=>$this->getSchool()->id,
            ])->with('subject')->get();
        // $subjects = auth()->user()->student->section->subject;

        $response = array(

            'code'    => 100,
            'data'=>[
                'subjects' => $subjects,
            ]
        );
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $response = array(
                'error'   => true,
                'message' => trans('error_occurred'),
                'code'    => 103,
            );
            return response()->json($response, 500);
        }
    }
    public function studentParent(Request $request){
        try {
        $student = auth()->user()->student;

            $response = array(

                'code'    => 100,
                'data'=>[
                    'studentParent' => $student->parent,
                ]
            );
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $response = array(
                'error'   => true,
                'message' => trans('error_occurred'),
                'code'    => 103,
            );
            return response()->json($response, 500);
        }
    }
    public function studentSchool(Request $request){
        try {
        $section = auth()->user()->student;
        $school  = Schools::find($section->school_id);
            $response = array(

                'code'    => 100,
                'data'=>[
                    'school' => $school,
                ]
            );
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $response = array(
                'error'   => true,
                'message' => trans('error_occurred'),
                'code'    => 103,
            );
            return response()->json($response, 500);
        }
    }
    public function getAcadimicYear(Request $request){
        try {
        $acadimicYear = getYearNow();
            $response = array(

                'code'    => 100,
                'data'=>[
                    'acadimicYear' => $acadimicYear,
                ]
            );
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $response = array(
                'error'   => true,
                'message' => trans('error_occurred'),
                'code'    => 103,
            );
            return response()->json($response, 500);
        }
    }
    public function getSettings(Request $request){
        try {
            $settings=   $this->getSchool()->setting;

            $response = array(

                'code'    => 100,
                'data'=>[
                    'settings' => $settings,
                ]
            );
            return response()->json($response, 200);

        } catch (\Throwable $th) {
            $response = array(
                'error'   => true,
                'message' => trans('genirale.error_occurred'),
                'code'    => 103,
            );
            return response()->json($response, 500);
        }
    }
    public function getAnnouncementSchool(Request $request){
        try {

            $school_announcement=   SchoolAnnoucement::where('school_id',$this->getSchool()->id)->get();

            $response = array(

                'code'    => 100,
                'data'=>[
                    'announcement' => $school_announcement,
                ]
            );
            return response()->json($response, 200);

        } catch (\Throwable $th) {
            $response = array(
                'error'   => true,
                'message' => trans('genirale.error_occurred'),
                'code'    => 103,
            );
            return response()->json($response, 500);
        }
    }
    public function getRecommandation(Request $request){
        try {

            $sql=   ClassScraping::where('grad_id',$this->getSchool()->grade_id);
            $classe = auth()->user()->student->section->classe;
            $name=$classe->getTranslation('name', 'ar');
            $class_scraper=  $sql->where('name', 'LIKE', "%$name%")->first();
            $recommandations= $class_scraper->subjects;

            $response = array(

                'code'    => 100,
                'data'=>[
                    'recommandations' => $recommandations,
                ]
            );
            return response()->json($response, 200);

        } catch (\Throwable $th) {
            $response = array(
                'error'   => true,
                'message' => trans('genirale.error_occurred'),
                'code'    => 103,
            );
            return response()->json($response, 500);
        }
    }
    
    public function getAttandance(Request $request){
        try {
            // return $request;

        $carbonDate = Carbon::parse($request->date);
        $formattedDate = $carbonDate->format('Y-m-d');
        $attendances =Attendance::where([
            'date'=>  $formattedDate,
            'student_id'=>auth()->user()->student->id,
            'session_year'=>$this->getYearNow()->id,
            'school_id'=>$this->getSchool()->id,
            'type'=>0,
        ])->get();
        $totalPresent =Attendance::where([

            'student_id'=>auth()->user()->student->id,
            'session_year'=>$this->getYearNow()->id,
            'school_id'=>$this->getSchool()->id,
            'type'=>1,
        ])->count();
        $totalAbsent =Attendance::where([
            'student_id'=>auth()->user()->student->id,
            'session_year'=>$this->getYearNow()->id,
            'school_id'=>$this->getSchool()->id,
            'type'=>0,
        ])->count();

            $response = array(

                'code'    => 100,
                'data'=>[
                    'attendances' => $attendances,
                    'totalPresent' => $totalPresent,
                    'totalAbsent' => $totalAbsent,
                ]
            );
            return response()->json($response, 200);
        } catch (\Exception $e) {
            $response = array(
                'error'   => true,
                'message' => trans('error_occurred'),
                'code'    => 103,
            );
            return response()->json($response, 500);
        }
    }
    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $response = array(
                'error' => true,
                'message' => $validator->errors()->first(),
                'code' => 102,
            );
            return response()->json($response);
        }
        if (Auth::guard('student')->attempt(['username' => $request->username, 'password' => $request->password])) {

            $auth = Auth::guard('student')->user();
            // $auth->update(['token'=>$request->token]);
            $student_infos=  Student::find($auth->student_acount_id);
            $userAuth=  StudentAcount::find($auth->id);
            $userAuth->token=$request->token;
            $userAuth->save();
            $token = $auth->createToken($auth->username)->plainTextToken;
            // $auth->tokens()->delete();
            $response = array(
                'message' => 'User logged-in!',
                'token' => $token,
                'data' => [
                    'studentAccount'=>$auth,
                    'studentInfo'=>$auth->student,
                ],
                'code' => 100,
            );
            return response()->json($response, 200);
        } else {
            $response = array(
                'error' => true,
                'message' => 'Invalid Login Credentials',
                'code' => 101
            );
            return response()->json($response, 200);
        }
    }
}
