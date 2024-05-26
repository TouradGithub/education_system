<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreGrades;
use Illuminate\Support\Facades\Validator;
use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('pages.grades.index');
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
    public function store(StoreGrades $request)
    {

        try {
        //   $validated = $request->validated();
          $Grade = new Grade();

          $Grade->name = ['en' => $request->name_en, 'ar' => $request->name];
          $Grade->notes = $request->notes;
          $Grade->save();

        $response = [
            'error' => false,
            'message' => trans('genirale.data_store_successfully')
        ];
        }catch (\Exception $e){
            $response = [
                'error' => true,
                'message' =>   trans('genirale.error_occurred')
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

        $sql = Grade::where('id', '!=', 0);
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
            $operate .= '<a class="btn btn-xs btn-gradient-danger btn-rounded btn-icon deletedata" data-id=' . $row->id . ' data-url=' . route('web.grades.destroy', $row->id) . ' title="Delete"><i class="fa fa-trash"></i></a>';

           $tempRow['id'] = $row->id;
           $tempRow['no'] = $no++;
           $tempRow['name'] =$row->getTranslation('name', 'ar');
           $tempRow['name_en'] =$row->getTranslation('name', 'en');
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
        // if (!Auth::user()->can('holiday-edit')) {
        //     $response = array(
        //         'error' => true,
        //         'message' => trans('no_permission_message')
        //     );
        //     return response()->json($response);
        // }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'name_en' => 'required',
        ]);

        if ($validator->fails()) {
            $response = array(
                'error' => true,
                'message' => $validator->errors()->first()
            );
            return response()->json($response);
        }
        try {
            $grade = Grade::find($request->id);
            $grade->name = ['en' => $request->name_en, 'ar' => $request->name];
            $grade->notes = $request->notes;
            $grade->save();
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


    public function destroy($id)
    {

        // if (!Auth::user()->can('holiday-delete')) {
        //     $response = array(
        //         'error' => true,
        //         'message' => trans('no_permission_message')
        //     );
        //     return response()->json($response);
        // }

        try {
            Grade::find($id)->delete();
            $response = array(
                'error' => false,
                'message' => trans('genirale.data_delete_successfully')
            );
        } catch (Throwable $e) {

            $response = array(
                'error' => true,
                'message' => trans('genirale.error_occurred')
            );

        }

        return response()->json($response);

    }
}
