<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\Test;
use App\Models\Section;
use Illuminate\Http\Request;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.schools.students.tests.index');
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
        // if (!Auth::user()->can('attendance-create') || !Auth::user()->can('attendance-edit')) {
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

            $getid = Test::select('id')->where([
                'subject_id' =>  $request->subject_id,
                'section_id' => $request->section_id,
                'trimester_id' => $request->trimester_id,
                ])->get();

            for ($i = 0; $i < count($request->student_id); $i++) {

                if (count($getid) > 0) {
                    $attendance = Test::find($getid[$i]['id']);
                    $a = "grade" . $request->student_id[$i];
                } else {
                    $attendance = new Test();
                    $a = "grade" . $request->student_id[$i];
                }
                $attendance->student_id = $request->student_id[$i];
                $attendance->school_id = getSchool()->id;
                $attendance->session_year = getYearNow()->id;
                $attendance->section_id = $request->section_id;
                $attendance->subject_id = $request->subject_id;
                $attendance->trimester_id = $request->trimester_id;
                $attendance->grade = $request->$a;
            $attendance->save();
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

                        $chkCount = Test::InTest()->where(
                            [
                                'subject_id'              =>   $request->subject_id,
                                'section_id'  => $request->section_id,
                                'trimester_id'      => $request->trimester_id
                            ])->count();




                if ( $chkCount > 0) {

                $sql2 = Test::InTest()->with('student')->where(
                [
                    'subject_id'              =>   $request->subject_id,
                    'section_id'  => $request->section_id,
                    'trimester_id'      => $request->trimester_id
                ]);
                $total = $sql2->count();
                $res = $sql2->get();
                $bulkData = array();
                $bulkData['total'] = $total;
                $rows = array();
                $tempRow = array();
                $no = 1;
                foreach ($res as $row) {
                    $get_type = $row->type;
                    $tempRow['grade'] =  '  <input type="text" oninput="validateGrade(this)" style="width: 100%;font-weight: bold;" name="grade'.$row->student_id.'" class="form-control"  value="'.$row->grade.'">';
                    $tempRow['id'] = $row->id;
                    $tempRow['student_id'] = "<input type='text' name='student_id[]' class='form-control' readonly value=" . $row->student_id . ">";
                    $tempRow['roll_number'] = $row->student->roll_number;
                    $tempRow['name'] = $row->student->first_name . ' ' . $row->student->last_name;

                    $rows[] = $tempRow;
                }
            } else {

                $section = Section::find($request->section_id);
                $sql =  $section->students;

                $res = $sql;
                $bulkData = array();
                $rows = array();
                $tempRow = array();
                $no = 1;
                foreach ($res as $row) {

                    $tempRow['grade'] =  '  <input type="number" oninput="validateGrade(this)" style="width: 100%;font-weight: bold;" name="grade'.$row->id.'" class="form-control"  value="">';


                    $tempRow['id'] = $row->id;
                    $tempRow['student_id'] = "<input type='text' name='student_id[]' class='form-control' readonly value=" . $row->id. ">";
                    $tempRow['roll_number'] = $row->roll_number;
                    $tempRow['name'] = $row->first_name . ' ' . $row->last_name;
                    $rows[] = $tempRow;

                }
            }

            $bulkData['rows'] = $rows;
            }else{
                $bulkData['rows']=[];
            }


        return response()->json($bulkData);
    }



    public function edit(Test $test)
    {
        //
    }

    public function update(Request $request, Test $test)
    {
        //
    }


    public function destroy(Test $test)
    {
        //
    }
}
