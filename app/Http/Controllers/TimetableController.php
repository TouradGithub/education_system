<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use Illuminate\Http\Request;
use App\Models\Grade;
use Illuminate\Support\Facades\Auth;
use App\Models\SubjectTeacher;
class TimetableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if (!Auth::user()->can('school-timetable-index') ) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return redirect(route('school.school.home'))->withErrors($response);
        }
        $class_sections = Grade::find(getSchool()->grade_id)->classes;
        return view('pages.schools.timetable.index', compact('class_sections'));
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

        if (!Auth::user()->can('school-timetable-create') ) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return redirect(route('school.school.home'))->withErrors($response);
        }
        $request->validate([
            'day' => 'required',
            'class_section_id' => 'required',
            'section_id' => 'required',
        ]);
        try {

            $day_name = $request->day;
            $class_section_id = $request->class_section_id;
                if ($day_name == 'monday') {
                    $day = 7;
                } elseif ($day_name == 'tuesday') {
                    $day = 1;
                } elseif ($day_name == 'wednesday') {
                    $day = 2;
                } elseif ($day_name == 'thursday') {
                    $day = 3;
                } elseif ($day_name == 'friday') {
                    $day = 4;
                } elseif ($day_name == 'saturday') {
                    $day = 5;
                } elseif ($day_name == 'sunday') {
                    $day = 6;
                }
            $a = $day_name . "_group";
            foreach ($request->$a as $data) {

                if (isset($data['id']) && $data['id'] != '') {
                    $timetable = Timetable::find($data['id']);
                } else {
                    $timetable = new Timetable();
                }
                if( !$data['subject_id'] ||  !$data['teacher_id']){
                    return redirect()->back()->with('error', trans('genirale.error_occurred'));

                }


                $subject_teacher_id = SubjectTeacher::where('subject_id', $data['subject_id'])
                ->where('teacher_id', $data['teacher_id'])
                ->where('class_section_id', $request->section_id)
                ->value('id');

                $timetable->subject_teacher_id = ($subject_teacher_id) ?? 0;
                $timetable->section_id = $request->section_id;
                $timetable->start_time = $data['start_time'];
                $timetable->end_time = $data['end_time'];
                $timetable->school_id = getSchool()->id;
                $timetable->session_year = getYearNow()->id;
                $timetable->day = $day;
                $timetable->note = ($data['note']) ?? '';
                $timetable->save();
            }


            return redirect()->back()->with('success', trans('genirale.data_store_successfully'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', trans('genirale.error_occurred'));
        }
    }

    public function class_timetable()
    {
        if (!Auth::user()->can('school-class-timetable') ) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return redirect(route('school.school.home'))->withErrors($response);
        }
        $class_sections = Grade::find(getSchool()->grade_id)->classes;
        return view('pages.schools.timetable.class_timetable', compact('class_sections'));
    }

    public function getSubjectByClassSection(Request $request)
    {
        $subjects = SubjectTeacher::InSubjectTeacher()->where('class_section_id', $request->class_id)
                    ->with('subject')
                    ->get();
        return response($subjects);
    }
    public function teacher_timetable()
    {
        // check the user if teacher exists
        // $user = Auth::user()->teacher;
        // if ($user) {
            // if teacher exists then send the timetable data directly to view by its credentials
            $class_sections = Grade::find(getSchool()->grade_id)->classes;
            // $subject_teacher = SubjectTeacher::where('teacher_id', $user->id)->pluck('id');
            // $timetable = Timetable::with('subject_teacher', 'class_section')->whereIn('subject_teacher_id', $subject_teacher)->get()->toArray();
            // $day = Timetable::select('day', 'day_name')->whereIn('subject_teacher_id', $subject_teacher)->groupBy('day', 'day_name')->get()->toArray();
            // $teacher_data = [
            //     'timetable' => $timetable,
            //     'days' => $day
            // ];
            return view('pages.schools.timetable.teacher_timetable', compact('class_sections'));

    }

    public function getteacherbysubject(Request $request)
    {
        // return $request;
        $teacher = SubjectTeacher::where(['class_section_id' => $request->class_section_id, 'subject_id' => $request->subject_id])->with('teacher')->get();
        return response($teacher);
    }

    public function checkTimetable(Request $request)
    {
        $timetable = Timetable::with('subject_teacher')->where(['section_id' => $request->section_id, 'day' => $request->day])
        // ->where(['class_section_id' => $request->class_id, 'day' => $request->day])
        ->get();
        // $timetable = Grade::where('id',0)->get();
        return response($timetable);
        // return response($timetable);
    }
    public function gettimetablebyclass(Request $request)
    {
        // Session::put('class_timetable', $request->class_section_id);

        $timetable = Timetable::where('section_id', $request->class_section_id)->with('subject_teacher')->orderBy('day', 'asc')->get();

        $day = Timetable::select('day')->where('section_id', $request->class_section_id)->groupBy('day')->get();

        return $data = [
            'timetable' => $timetable,
            'days' => $day
        ];
    }
    public function getTimetable(Request $request)
    {
        // Session::put('class_timetable', $request->class_section_id);

        $timetable = Timetable::with('subject_teacher')->where('section_id', $request->section_id)
                                ->where('day', $request->day)
                                ->get();

        return response($timetable);
    }
    /**
     * Display the specified resource.
     */
    public function show(Timetable $timetable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Timetable $timetable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Timetable $timetable)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Timetable $timetable)
    {


        if ($timetable) {
            $timetable->delete();

            return response()->json([
                'error' => false,
                'message' => 'Timetable deleted successfully'
            ]);
        }

        return response()->json([
            'error' => true,
            'message' => 'Timetable not found'
        ]);
    }
}
