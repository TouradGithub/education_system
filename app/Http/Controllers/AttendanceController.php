<?php

namespace App\Http\Controllers;
use Carbon\Carbon;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Section;
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
        // if (!Auth::user()->can('attendance-create') || !Auth::user()->can('attendance-edit')) {
        //     $response = array(
        //         'error' => true,
        //         'message' => trans('no_permission_message')
        //     );
        //     return response()->json($response);
        // }

        $validator = Validator::make($request->all(), [
            'timetable_day'=>'required',
            'section_id' => 'required',
            'student_id' => 'required',
            'date' => 'required',
        ]);
        if ($validator->fails()) {
            $response = array(
                'error' => true,
                'message' => $validator->errors()->first()
            );
            return response()->json($response);
        }
        try {

            $getid = Attendance::select('id')->where([
                'date' => Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d'),
                'section_id' => $request->section_id,
                'timetable_id' => $request->timetable_day,
                ])->get();

            for ($i = 0; $i < count($request->student_id); $i++) {

                if (count($getid) > 0) {
                    $attendance = Attendance::find($getid[$i]['id']);
                    $a = "type" . $request->student_id[$i];
                } else {
                    $attendance = new Attendance();
                    $a = "type" . $request->student_id[$i];
                }
                $attendance->student_id = $request->student_id[$i];
                $attendance->school_id = getSchool()->id;
                $attendance->session_year = getYearNow()->id;
                $attendance->section_id = $request->section_id;
                $attendance->timetable_id = $request->timetable_day;
                $attendance->type = $request->$a;

                $attendance->date = Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d'); // Updated line
                $attendance->save();
            }
            $response = [
                'error' => false,
                'message' => trans('data_store_successfully')
            ];
        } catch (Exception $e) {
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

            if($request->has('section_id') && $request->section_id != null){
                if(isset($request->date) && $request->date != ''){
                        $chkCount = Attendance::with('student')->where(
                            [
                                'date'              =>  Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d'),
                                'section_id'  => $request->section_id,
                                'timetable_id'      => $request->timetable_id
                            ])->count();
                }else{
                        $chkCount=0;
                }



                if (isset($request->date) && $request->date != '' && $chkCount > 0) {

                $sql2 = Attendance::with('student')->where(
                [
                    'date'              =>  Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d'),
                    'section_id'  => $request->section_id,
                    'timetable_id'      => $request->timetable_id
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
                    if ($get_type == 1) {
                        $type = '<div class="d-flex"><div class="form-check-inline"><label class="form-check-label">
                        <input required type="radio" class="type"  name="type' . $row->student_id . '" value="1" checked>Present
                        </label></div>';
                        $type .= '<div class="form-check-inline"><label class="form-check-label">
                        <input type="radio" class="type"  name="type' . $row->student_id . '" value="0">Absent
                        </label></div></div>';
                    } else if ($get_type == 0) {
                        $type = '<div class="d-flex"><div class="form-check-inline"><label class="form-check-label">
                        <input required type="radio" class="type"  name="type' . $row->student_id . '" value="1">Present
                        </label></div>';
                        $type .= '<div class="form-check-inline"><label class="form-check-label">
                        <input type="radio" class="type"  name="type' . $row->student_id . '" value="0" checked>Absent
                        </label></div></div>';
                    } else {
                        $type = '<div class="d-flex"><div class="form-check-inline"><label class="form-check-label">
                        <input required type="radio" class="type"  name="type' . $row->student_id . '" value="1">Present
                        </label></div>';
                        $type .= '<div class="form-check-inline"><label class="form-check-label">
                        <input type="radio" class="type"  name="type' . $row->student_id . '" value="0">Absent
                        </label></div></div>';
                    }
                    $tempRow['id'] = $row->id;
                    $tempRow['student_id'] = "<input type='text' name='student_id[]' class='form-control' readonly value=" . $row->student_id . ">";
                    $tempRow['roll_number'] = $row->student->roll_number;
                    $tempRow['name'] = $row->student->first_name . ' ' . $row->student->last_name;
                    $tempRow['type'] = $type;
                    $rows[] = $tempRow;
                }
            } else {

                $section = Section::find($request->section_id);
                $sql =  $section->students;
                // $sql = Students::where('class_section_id', $class_section_id);
                // if (isset($_GET['search']) && !empty($_GET['search'])) {
                //     $search = $_GET['search'];
                //     $sql->where('id', 'LIKE', "%$search%")
                //         ->orWhereHas('user', function ($q) use ($search) {
                //             $q->whereRaw("concat(first_name,' ',last_name) LIKE '%" . $search . "%'")->orwhere('first_name', 'LIKE', "%$search%")->orwhere('last_name', 'LIKE', "%$search%");
                //         });
                // }
                    $absent=__('student.absent');
                    $prsent=__('student.present');
                // $sql->orderBy($sort, $order)->skip($offset)->take($limit);
                $res = $sql;
                $bulkData = array();
                $rows = array();
                $tempRow = array();
                $no = 1;
                foreach ($res as $row) {

                    $type = '<div class="d-flex"><div class="form-check-inline"><label class="form-check-label">
                    <input required type="radio" class="type"  name="type' .$row->id. '" value="1"> ' . $prsent . '</label></div>';

                    $type .= '<div class="form-check-inline"><label class="form-check-label">
                    <input type="radio" class="type"  name="type' .$row->id . '" value="0">  ' . $absent . '
                    </label></div></div>';

                    $tempRow['id'] = 3;
                    $tempRow['id'] = $row->id;
                    $tempRow['student_id'] = "<input type='text' name='student_id[]' class='form-control' readonly value=" . $row->id. ">";
                    $tempRow['roll_number'] = $row->roll_number;
                    $tempRow['name'] = $row->first_name . ' ' . $row->last_name;
                    $tempRow['type'] = $type;
                    $rows[] = $tempRow;

                }
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
        $section=Section::find($request->section_id);
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
