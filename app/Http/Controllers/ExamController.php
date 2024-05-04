<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Test;
use App\Models\ClassRoom;
class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return  view('pages.schools.students.exams.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // if (!Auth::user()->can('school-attendance-create') || !Auth::user()->can('attendance-edit')) {
        //     $response = array(
        //         'error' => true,
        //         'message' => trans('no_permission_message')
        //     );
        //     return response()->json($response);
        // }

        $validator = Validator::make($request->all(), [
            'trimester_id'=>'required',
            'section_id' => 'required',
            'student_id' => 'required',
            'subject_id' => 'required',
        ]);
        if ($validator->fails()) {
            $response = array(
                'error' => true,
                'message' => $validator->errors()->first()
            );
            return response()->json($response);
        }
        try {



            $exams = Exam::where([
                'subject_id' =>  $request->subject_id,
                'section_id' => $request->section_id,
                'trimester_id' => $request->trimester_id,
                ])->get();


        foreach ($request->student_id as $studentId) {
            $exam = $exams->firstWhere('student_id', $studentId);

            if (!$exam) {
                // Create a new Test record
                $exam = new Exam();
                $exam->student_id = $studentId;
                $exam->school_id = getSchool()->id;
                $exam->session_year = getYearNow()->id;
                $exam->section_id = $request->section_id;
                $exam->subject_id = $request->subject_id;
                $exam->trimester_id = $request->trimester_id;
                // $test->grade = $request->$a;
            }
            if($request->input('grade'.$studentId)){
                $exam->grade = $request->input('grade'.$studentId);

                // Save the Test record
                $exam->save();
            }
        }
            $response = [
                'error' => false,
                'message' => trans('genirale.data_store_successfully')
            ];
        } catch (Exception $e) {
            $response = array(
                'error' => true,
                'message' => trans('genirale.error_occurred'),
                'data' => $e
            );
        }
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        // return $request;

        $offset = 0;
        $limit = 10;
        $sort = 'roll_number';
        $order = 'ASC';

        if (isset($_GET['offset']))
            $offset = $_GET['offset'];
        if (isset($_GET['limit']))
            $limit = $_GET['limit'];

        if (isset($_GET['sort']))
            $sort = $_GET['sort'];
        if (isset($_GET['order']))
            $order = $_GET['order'];

            if(
                $request->has('section_id') && $request->section_id != null &&
                $request->has('subject_id') && $request->subject_id != null &&
                $request->has('trimester_id') && $request->trimester_id != null

            ){


                $section = ClassRoom::find($request->section_id);
                $sql =  $section->students;


                $res = $sql;
                $bulkData = array();
                $rows = array();
                $tempRow = array();
                $no = 1;
                foreach ($res as $row) {
                    $test = Exam::InExam()->where(
                        [
                            'subject_id'              =>   $request->subject_id,
                            'section_id'  => $request->section_id,
                            'trimester_id'      => $request->trimester_id,
                            'student_id'      => $row->id
                        ])->first();
                        if($test){
                            $tempRow['grade'] =  '  <input type="text" oninput="validateGrade(this)" style="width: 100%;font-weight: bold;" name="grade'.$test->student_id.'" class="form-control"  value="'.$test->grade.'">';

                        }else{
                            $tempRow['grade'] =  '  <input type="number" oninput="validateGrade(this)" style="width: 100%;font-weight: bold;" name="grade'.$row->id.'" class="form-control"  value="">';

                        }

                    $tempRow['id'] = $row->id;
                    $tempRow['student_id'] = "<input type='text' name='student_id[]' class='form-control' readonly value=" . $row->id. ">";
                    $tempRow['roll_number'] = $row->roll_number;
                    $tempRow['name'] = $row->first_name . ' ' . $row->last_name;
                    $rows[] = $tempRow;

                }
            // }

            $bulkData['rows'] = $rows;
            }else{
                $bulkData['rows']=[];
            }

        return response()->json($bulkData);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exam $exam)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Exam $exam)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exam $exam)
    {
        //
    }
}
