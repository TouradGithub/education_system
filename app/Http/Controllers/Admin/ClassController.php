<?php

namespace App\Http\Controllers\Admin;
use App\Http\Requests\StoreGrades;
use App\Models\Classes;
use App\Models\Grade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::user()->can('classes-list')) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return redirect()->back();

        }
        return view('pages.classes.index');
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
        if (!Auth::user()->can('classes-create')) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return redirect()->back();

        }
        try {
            $validated = $request->validated();
            $classes = new Classes();

            $classes->name = ['en' => $request->name_en, 'ar' => $request->name];
            $classes->grade_id = $request->grade_id;
            $classes->notes = $request->notes;
            $classes->save();

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
    public function show(Classes $classes)
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

        $sql = Classes::where('id', '!=', 0);
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
            if (Auth::user()->can('classes-edit')){
                $operate .= '<a class="btn btn-xs btn-gradient-primary btn-rounded btn-icon editdata" data-id=' . $row->id . ' title="Edit" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';

            }

            if (Auth::user()->can('classes-delete')){
                $operate .= '<a class="btn btn-xs btn-gradient-danger btn-rounded btn-icon deletedata" data-id=' . $row->id . ' data-url=' . route('web.classes.destroy', $row->id) . ' title="Delete"><i class="fa fa-trash"></i></a>';

            }

           $tempRow['id'] = $row->id;
           $tempRow['no'] = $no++;
           $tempRow['name'] =$row->getTranslation('name', 'ar');
           $tempRow['name_en'] =$row->getTranslation('name', 'en');
           $tempRow['grade'] =$row->grade->name;
           $tempRow['grade_id'] =$row->grade->id;
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
    public function edit(Classes $classes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classes $classes)
    {
        if (!Auth::user()->can('classes-edit')) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return redirect()->back();

        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'name_en' => 'required',
            'grade_id' => 'required',
        ]);

        if ($validator->fails()) {
            $response = array(
                'error' => true,
                'message' => $validator->errors()->first()
            );
            return response()->json($response);
        }
        try {
            $class = Classes::find($request->id);
            $class->name = ['en' => $request->name_en, 'ar' => $request->name];
            $class->grade_id = $request->grade_id;
            $class->notes = $request->notes;
            $class->save();
            $response = array(
                'error' => false,
                'message' => trans('genirale.data_update_successfully')
            );
        } catch (\Throwable $e) {
            $response = array(
                'error' => true,
                'message' => trans('genirale.error_occurred')
            );
        }
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        if (!Auth::user()->can('classes-delete')) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return redirect()->back();

        }
        try {
            Classes::find($id)->delete();
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

    public function getClasses(int $id)
    {
        try {
           $grade= Grade::find($id);

            $response = $grade->classes->map(function ($class) {
                return [
                    'id' => $class->id,
                    'name' => $class->getTranslation('name', app()->getLocale()), // Assuming 'arabic_name' is the attribute
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
