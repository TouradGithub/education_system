<?php

namespace App\Http\Controllers;
use Carbon\Carbon;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Student;
use App\Models\StudentAcount;
use App\Models\ClassRoom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // if (!Auth::user()->can('attendance-list')) {
        //     $response = array(
        //         'message' => trans('no_permission_message')
        //     );
        //     return redirect(route('home'))->withErrors($response);
        // }
        // $teacher_id = Auth::user()->teacher->id;
        // $class_section_ids = ClassTeacher::where('class_teacher_id',$teacher_id)->pluck('class_section_id');
        // $class_sections = ClassSection::with('class', 'section','classTeachers','class.streams')->whereIn('id',$class_section_ids)->get();
        return view('pages.attendance.index');
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



        $validator = Validator::make($request->all(), [
            'timetable_day'=>'required',
            'section_id' => 'required',
            'student_id' => 'required',
            'date' => 'required',
        ]);


        //   $getid = Attendance::select('id')->where([

        //     );
        // }
        // return response()->json($response);
        $attendances = Attendance::where([
            'date' => Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d'),
            'section_id' => $request->section_id,
            'timetable_id' => $request->timetable_day,
        ])->get();
        // Loop through each student ID in the request
        foreach ($request->student_id as $studentId) {
            // Check if attendance record exists for the student on the given date, section, and timetable
            $attendance = $attendances->firstWhere('student_id', $studentId);
            // Create a new attendance record if it doesn't exist
            if (!$attendance) {
                $attendance = new Attendance();
                $attendance->student_id = $studentId;
                $attendance->school_id = getSchool()->id;
                $attendance->session_year = getYearNow()->id;
                $attendance->section_id = $request->section_id;
                $attendance->timetable_id = $request->timetable_day;
                $attendance->date = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
            }
            // Assign attendance type based on the request data
            if($request->input('type' . $studentId)==0){
                 $user = Student::find($studentId);
                //   return response()->json([
                //         'error' => false,
                //         'message' =>$user->studentAccount->token
                //     ]);
                $message = "تم غياب هذا التلميذ تاريخ " . Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
                send_notification($user->studentAccount, "غياب", $message, "announce");
                send_parent_notification($user->parent, "غياب", $message, "announce");

            }
            $attendance->type = $request->input('type' . $studentId);

            // Save the attendance record
            $attendance->save();
        }

        // Respond with success message
        return response()->json([
            'error' => false,
            'message' => trans('genirale.data_store_successfully')
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {

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

            if($request->has('section_id') && $request->section_id != null
            && isset($request->date) && $request->date != ''
            && isset($request->timetable_id) && $request->timetable_id != ''
            ){
                $section = ClassRoom::find($request->section_id);
                $sql =  $section->students;
                $absent=__('student.absent');
                $prsent=__('student.present');
                $res = $sql;
                $bulkData = array();
                $rows = array();
                $tempRow = array();
                $no = 1;
                foreach ($res as $row) {
                //  $test=   $row;
                if(Attendance::where([
                    'student_id'=>$row->id,
                    'section_id'=>$request->section_id,
                    'timetable_id'=>$request->timetable_id
                    ])->first()){

                    $attendance = Attendance::where([
                    'student_id'=>$row->id,
                    'section_id'=>$request->section_id,
                    'timetable_id'=>$request->timetable_id
                    ])->first();

                    $get_type = $attendance->type;

                 if ($get_type == 1) {
                        $type = '<div class="d-flex"><div class="form-check-inline"><label class="form-check-label">
                        <input required type="radio" class="type"  name="type' . $row->id . '" value="1" checked>Present
                        </label></div>';
                        $type .= '<div class="form-check-inline"><label class="form-check-label">
                        <input type="radio" class="type"  name="type' . $row->id . '" value="0">Absent
                        </label></div></div>';
                    } else if ($get_type == 0) {
                        $type = '<div class="d-flex"><div class="form-check-inline"><label class="form-check-label">
                        <input required type="radio" class="type"  name="type' . $row->id . '" value="1">Present
                        </label></div>';
                        $type .= '<div class="form-check-inline"><label class="form-check-label">
                        <input type="radio" class="type"  name="type' . $row->id . '" value="0" checked>Absent
                        </label></div></div>';
                    }
                }else{
                    $type = '<div class="d-flex"><div class="form-check-inline"><label class="form-check-label">
                    <input required type="radio" class="type"  name="type' . $row->id . '" value="1">Present
                    </label></div>';
                    $type .= '<div class="form-check-inline"><label class="form-check-label">
                    <input type="radio" class="type"  name="type' . $row->id . '" value="0">Absent
                    </label></div></div>';
                }


                    $tempRow['id'] = $row->id;
                    $tempRow['student_id'] = "<input type='text' name='student_id[]' class='form-control' readonly value=" . $row->id. ">";
                    $tempRow['roll_number'] = $row->roll_number;
                    $tempRow['name'] = $row->first_name . ' ' . $row->last_name;
                    $tempRow['type'] = $type;
                    $rows[] = $tempRow;
            //     }

            }

            $bulkData['rows'] = $rows;
        }else{
                $bulkData['rows']=[];
        }


        return response()->json($bulkData);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        //
    }
    function getStudentAttendance(Request $request){
        $section=ClassRoom::find($request->section_id);
        $students=$section->students;
        return response($students);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
    public function getAttendanceData(Request $request)
    {
        $response = Attendance::select('type')->where(['date' => date('Y-m-d', strtotime($request->date)), 'class_section_id' => $request->class_section_id])->pluck('type')->first();
        return response()->json($response);
    }
}
