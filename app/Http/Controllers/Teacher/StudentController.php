<?php

namespace App\Http\Controllers\Teacher;
use App\Models\MyParent;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use App\Models\StudentAcount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Section;
use App\Http\Requests\StoreStudentsRequest;
class StudentController extends Controller
{

    public function index($id){

          $section=Section::find($id);
        return  view('pages.teachers.students.index',compact('section'));
    }

    public function show(Request $request){




        $sql = Student::InStudent()->where('section_id',$request->section_id);


        $res = $sql->get();

        $bulkData = array();
        $rows = array();
        $tempRow = array();
        $no = 1;
        foreach ($res as $row) {
            $operate = '';

           $tempRow['id'] = $row->id;
           $tempRow['first_name'] =$row->first_name;
           $tempRow['last_name'] =$row->last_name;
           $tempRow['roll_number'] =$row->roll_number;
           $tempRow['gender'] =$row->gender;
           $tempRow['parent_id'] = $row->parent->father_first_name.' '. $row->parent->father_last_name;
           $tempRow['operate'] =$operate;
           $rows[] = $tempRow;
        }

        $bulkData['rows'] = $rows;
        return response()->json($bulkData);
    }



}
