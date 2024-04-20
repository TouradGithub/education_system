<?php

namespace App\Http\Controllers\Teacher;
use App\Http\Controllers\Controller;
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



        return view('pages.teachers.timetable.index');
    }





    public function getSubjectByClassSection(Request $request)
    {
        $subjects = SubjectTeacher::InSubjectTeacher()->where('class_section_id', $request->class_id)
                    ->with('subject')
                    ->get();
        return response($subjects);
    }



    public function gettimetablebyclass(Request $request)
    {
        $user= auth('teacher')->user();
        $sections = SubjectTeacher::where(['teacher_id' => $user->id,'school_id'=>getSchool()->id])->get();

        foreach( $sections as  $value){
            $day = Timetable::InTimetable()->select('day')
            ->where('section_id', $value->class_section_id)->groupBy('day')->get();
            $timetable = Timetable::InTimetable()->where([
                "subject_teacher_id"=>$value->id,
                'section_id'=> $value->class_section_id
            ])->with(['subject_teacher','section'])->orderBy('day', 'asc')->get();
        }




        return $data = [
            'timetable' => $timetable,
            'days' => $day
        ];
    }




}
