<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class SubjectController extends Controller
{

    public function index()
    {
        if (!Auth::user()->can('school-subject-index')) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return redirect()->back()->withErrors($response);

        }

        return view('pages.subject.index');
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        if (!Auth::user()->can('school-subject-create')) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return response()->json($response);

        }

        try {
            $messages = [
                'name.required'      => 'The name field is required.',
                'name.unique'        => 'The combination of name, class,  must be unique.',
                'code.required'      => 'The code field is required.',
                'code.unique'        => 'The code field must be unique.',
                'type.required'      => 'The type field is required.',
                'class_id.required'  => 'The class_id field is required.',
            ];

            $request->validate([
                'name'      => 'required|unique:subjects,name,NULL,id,class_id,' . $request->input('class_id') . ',school_id,' . getSchool()->id,
                'code'      => 'required',
                'image'     => 'nullable',
                'type'      => 'required',
                'notes'     => 'nullable',
                'class_id'  => 'required|unique:subjects,name,NULL,id,class_id,' . $request->input('class_id') . ',school_id,' . getSchool()->id,
            ], $messages);

// return "ok";
          $subject = new Subject();
          $subject->name =  $request->name;
          $subject->type =  $request->type;
          $subject->grade_id =   getSchool()->grade_id;
          $subject->class_id =  $request->class_id;
          $subject->school_id =  getSchool()->id;
          $subject->image =  $request->image;
          $subject->code =  $request->code;
          $subject->notes =  $request->notes;
          $subject->save();

          $response = [
            'error' => false,
            'message' => trans('data_store_successfully')
          ];

        }catch (\Exception $e){
            $response = [
                'error' => true,
                'message' =>  $e->getMessage()
            ];
        }

        return response()->json($response);

    }
    public function show()
    {

        $offset = 0;
        $limit = 10;
        $sort = 'id';
        $order = 'DESC';

        if (isset($_GET['offset']))
        $offset = $_GET['offset'];
        if (isset($_GET['limit']))
        $limit = $_GET['limit'];

        if (isset($_GET['sort']))
        $sort = $_GET['sort'];
        if (isset($_GET['order']))
        $order = $_GET['order'];

        $sql = Subject::where('school_id', getSchool()->id);
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $search = $_GET['search'];
            $sql->where('id', 'LIKE', "%$search%")
            ->orwhere('name', 'LIKE', "%$search%");
        }
        $total = $sql->count();

        $res = $sql->orderBy($sort, $order)->skip($offset)->take($limit)->get();
        $res = $sql->get();

        $bulkData = array();
        $bulkData['total'] = $total;
        $rows = array();
        $tempRow = array();
        $no = 1;
        foreach ($res as $row) {
            $operate = '';
            $operate .= '<a class="btn btn-xs btn-gradient-primary btn-rounded btn-icon editdata" data-id=' . $row->id . ' title="Edit" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';
            $operate .= '<a class="btn btn-xs btn-gradient-danger btn-rounded btn-icon deletedata" data-id=' . $row->id . ' data-url=' . route('school.subjects.destroy', $row->id) . ' title="Delete"><i class="fa fa-trash"></i></a>';

           // $data = getSettings('date_formate');

           $tempRow['id'] = $row->id;
           $tempRow['no'] = $no++;
           $tempRow['name'] =$row->name;
           $tempRow['code'] =$row->code;
           $tempRow['type'] =$row->name;
           $tempRow['class_id'] =$row->classRoom->name;
           $tempRow['operate'] =$operate;
           $tempRow['notes'] = $row->notes;


            $rows[] = $tempRow;
        }

        $bulkData['rows'] = $rows;
        return response()->json($bulkData);
    }



    public function edit(Grade $grade)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if (!Auth::user()->can('school-subject-edit')) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return response()->json($response);

        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'code' => 'required',
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            $response = array(
                'error' => true,
                'message' => $validator->errors()->first()
            );
        return response()->json($response);
        }
        try {
            $subject = Subject::find($request->id);
            $subject->name =  $request->name;
            $subject->type =  $request->type;
            $subject->image =  $request->image;
            $subject->code =  $request->code;
            $subject->notes =  $request->notes;
            $subject->save();
            $response = array(
                'error' => false,
                'message' => trans('data_update_successfully')
            );
        } catch (\Throwable $e) {
            $response = array(
                'error' => true,
                'message' => $e->getMessage()
            );
        }
        return response()->json($response);
    }


    public function destroy($id)
    {

        if (!Auth::user()->can('school-subject-delete')) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return response()->json($response);

        }

        try {
            Subject::find($id)->delete();
            $response = array(
                'error' => false,
                'message' => trans('data_delete_successfully')
            );
        } catch (Throwable $e) {

            $response = array(
                'error' => true,
                'message' => trans('error_occurred')
            );

        }

        return response()->json($response);

    }
}
