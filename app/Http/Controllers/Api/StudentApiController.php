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
class StudentApiController extends Controller
{


    public function logout(Request $request){
        try {
            auth()->user()->tokens()->delete();

        } catch (\Exception $e) {
            $response = array(
                'error' => true,
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
                'error'   => false,
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
                'error'   => false,
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
                'error'   => false,
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
                'error'   => false,
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
                'error'   => false,
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
                'error'   => false,
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
                'error'   => false,
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
                'error'   => false,
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
    public function studentSubject(Request $request){
        try {


        $section = auth()->user()->student->section->subject;

        $response = array(
            'error'   => false,
            'code'    => 100,
            'data'=>[
                'subjects' => $section,
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
                'error'   => false,
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
                'error'   => false,
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
                'error'   => false,
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
                'error' => false,
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
