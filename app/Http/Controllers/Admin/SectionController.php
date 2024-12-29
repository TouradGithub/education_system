<?php

namespace App\Http\Controllers\Admin;
use App\Http\Requests\StoreGrades;
use App\Models\Section;
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
        return view('pages.sections.index');
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
    public function store(StoreGrades  $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'name_en' => 'required',
            'grade_id' => 'required',
            'class_id' => 'required',
        ]);
        if ($validator->fails()) {
            $response = array(
                'error' => true,
                'message' => $validator->errors()->first()
            );
            return response()->json($response);
        }
        try {
            $validated = $request->validated();

            $section = new Section();
            $section->name = ['fr' => $request->name_en, 'ar' => $request->name];
            $section->grade_id = $request->grade_id;
            $section->class_id = $request->class_id;
            $section->school_id = "1";
            $section->notes = $request->notes;
            $section->save();

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

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
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

        $sql = Section::where('id', '!=', 0);
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
            $operate .= '<a class="btn btn-xs btn-gradient-danger btn-rounded btn-icon deletedata" data-id=' . $row->id . ' data-url=' . route('web.sections.destroy', $row->id) . ' title="Delete"><i class="fa fa-trash"></i></a>';

            $tempRow['id'] = $row->id;
           $tempRow['name'] = $row->getTranslation('name', 'fr');
           $tempRow['name_ar'] = $row->getTranslation('name', 'ar');
           $tempRow['grade'] =$row->grade->name;
           $tempRow['class'] =$row->classe->name;
           $tempRow['operate'] =$operate;
           $tempRow['notes'] = $row->notes;


            $rows[] = $tempRow;
        }

        $bulkData['rows'] = $rows;
        return response()->json($bulkData);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'name_en' => 'required',
                'grade_id' => 'required',
                'class_id' => 'required',
            ]);
            if ($validator->fails()) {
                $response = array(
                    'error' => true,
                    'message' => $validator->errors()->first()
                );
                return response()->json($response);
            }

            $section =Section::find($request->id);

            $section->name = ['fr' => $request->name_en, 'ar' => $request->name];
            $section->grade_id = $request->grade_id;
            $section->class_id = $request->class_id;
            $section->notes = $request->notes;
            $section->save();

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            Section::find($id)->delete();
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

    public function getSections(int $id)
    {
        try {
           $class= Classes::find($id);
        //
        $response = $class->sections->map(function ($section) {
            return [
                'id' => $section->id,
                'name' => $section->getTranslation('name', app()->getLocale()), // Assuming 'arabic_name' is the attribute
            ];
        });
        } catch (Throwable $e) {

            $response = array(
                'error' => true,
                'message' => trans('error_occurred')
            );

        }

        return response()->json($response);
    }
}
