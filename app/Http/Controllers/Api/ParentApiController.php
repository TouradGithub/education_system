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

class ParentApiController extends Controller
{
    public function getStudents(Request $request){

        try {

            $parent = auth()->user();

            $response = array(
                'code'    => 100,
                'data'=>[
                    'students' => $parent->students,
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
    public function getParentInfo(Request $request){

        try {

            $parent = auth()->user();

            $response = array(
                'code'    => 100,
                'data'=>[
                    'parent' => $parent,
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

    public function parentSubject(Request $request){

        try {

           $student= Student::find($request->id);
            $subjects=   SubjectTeacher::where([
                'class_section_id'=> $student->section->id,
                'school_id'=> $student->school_id,
            ])->with('subject')->get();

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
    public function getLessons(Request $request){
        try {
        $student= Student::find($request->id);

        $lessons =  $student->section->lessons;

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
    public function getTeachers(Request $request){
        try {
            $student= Student::find($request->id);


            $teachers=   SubjectTeacher::where([
                'class_section_id'=>$student->section->id,
                'school_id'=>$student->school_id,
            ])->with('teacher')->get();

                $response = array(

                    'code'    => 100,
                    'data'=>[

                        'teachers' => $teachers,
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
            $student= Student::find($request->id);
        $timeTable = $student->section->timeTable;
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
    public function getAttandance(Request $request){
        try {
        $student= Student::find($request->id);
        $carbonDate = Carbon::parse($request->date);
        $formattedDate = $carbonDate->format('Y-m-d');
        $attendances =Attendance::where([
            'date'=>  $formattedDate,
            'student_id'=>$student->id,
            'session_year'=>$student->academic_year,
            'school_id'=>$student->school_id,
        ])->get();
        $totalPresent =Attendance::where([
            'student_id'=>$student->id,
            'session_year'=>$student->academic_year,
            'school_id'=>$student->school_id,
            'type'=>1,
        ])->count();
        $totalAbsent =Attendance::where([
            'student_id'=>$student->id,
            'session_year'=>$student->academic_year,
            'school_id'=>$student->school_id,
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
                'message' => trans('genirale.error_occurred'),
                'code'    => 103,
            );
            return response()->json($response, 500);
        }
    }
    public function getSection(Request $request){
        try {
            $student= Student::find($request->id);
        $class = $student->section->classe;
                $section = $student->section;
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

    public function getExams(Request $request){
        try {
            $student= Student::find($request->id);
        $exams =  $student->exams;
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
            $student= Student::find($request->id);

            $tests =  $student->tests;

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


    public function getTrimesters(Request $request){
        try {

         $trimester=   Trimester::all();

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

    public function getAnnouncements(Request $request){
        try {
            $student= Student::find($request->id);

            $school_announcement=  $school_announcement=SchoolAnnoucement::where([
                'model'=>'App\Models\Student',
                'model_id'=>  $student->id,
            ]) ->orWhere([
                'model'=>'App\Models\School',
                'model_id'=> $student->school_id,
            ])->get();

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
        if (Auth::guard('parent')->attempt(['username' => $request->username, 'password' => $request->password])) {

            $parent = Auth::guard('parent')->user();

            $parent->token=$request->token;
            $parent->save();
            $token = $parent->createToken($parent->username)->plainTextToken;
            $response = array(
                'message' => 'User logged-in!',
                'token' => $token,
                'data' => [
                    'parent'=>$parent,
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
