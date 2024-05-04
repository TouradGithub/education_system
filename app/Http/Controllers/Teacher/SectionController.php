<?php

namespace App\Http\Controllers\Teacher;
use App\Http\Requests\StoreGrades;
use App\Models\ClassRoom;
use App\Models\Classes;
use Illuminate\Support\Facades\Validator;
use App\Models\Grade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.teachers.sections.index');
    }

    /**
     * Show the form for creating a new resource.
     */

    public function show()
    {


        $text=__("genirale.show_student");
        $Lesson=__("lesson.show_lessons");

        $teacher = auth('teacher')->user();
        $sections = $teacher->sectionTeachers;
        $sql = $sections;

        $res = $sql;

        $bulkData = array();
        $rows = array();
        $tempRow = array();
        $no = 1;
        foreach ($res as $row) {
            $operate = '';
            $operate .= '<a class="btn btn-primary" href="' . route("teacher.student.index.teacher", $row->section->id) . '" title="' . $text . '">' . $text . '</a>';
            $operate .= '<a class="btn btn-primary" href="' . route("teacher.lesson.create", $row->section) . '" title="' . $text . '">' . $Lesson . '</a>';

           $tempRow['id'] = $row->id;
           $tempRow['name'] = $row->section->getTranslation('name', app()->getLocale()).' - '.$row->section->classe->getTranslation('name', app()->getLocale());
           $tempRow['operate'] =$operate;


            $rows[] = $tempRow;
        }

        $bulkData['rows'] = $rows;
        return response()->json($bulkData);
    }



}
