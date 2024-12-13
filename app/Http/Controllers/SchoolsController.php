<?php

namespace App\Http\Controllers;
use App\Models\Schools;
use App\Models\Grade;
use App\Http\Requests\StoreSchool;
use Illuminate\Support\Facades\Hash;
use App\Models\Acadimy;
use App\Models\User;
use App\Models\Settings;
use App\Models\SchoolManegment;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class SchoolsController extends Controller
{

    public function index()
    {
        if (!Auth::user()->can('school-list')) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return redirect()->back();

        }
        $grades =Grade::all();
        $acadimy =Acadimy::all();
        $roles = Role::all()->pluck('name','name');
        return view('pages.schools.index',compact('grades','acadimy','roles'));
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
    public function store(StoreSchool $request)
    {
        if (!Auth::user()->can('school-create')) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return response()->json($response);

        }
        try {


            DB::beginTransaction();

            $school = Schools::create([
                'name' => $request->name,
                'description' => $request->description,
                'type' => $request->type,
                'grade_id'=>$request->grade_id,
                'adress' => $request->adress,
                'email' => $request->email,
                'image' => $request->image,
                'academy_id' => $request->academy_id,
            ]);

            $super_admin_role = Role::where('name', $request->input('roles'))->first();

            $schoolUser = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'role' =>  $super_admin_role->name,
                'password' => Hash::make($request->password),
                'model' => "App\Models\Schools",
                'model_id' => $school->id,
                'is_admin_school' => 1,
            ]);
            $setting = new Settings();
            $setting->school_id= $school->id;
            $setting->save();

            $super_admin_role = Role::where('name', $request->input('roles'))->first();

            $schoolUser->assignRole($super_admin_role);
            DB::commit();

            $response = array(
                'error' => false,
                'message' => trans('data_store_successfully')
            );

        }catch (Throwable $e) {
            $response = array(
                'error' => true,
                'message' => $e,
                'data' => $e
            );
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

        $sql = Schools::where('id', '!=', 0);
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
            if (Auth::user()->can('school-edit')){
                $operate .= '<a class="btn btn-xs btn-gradient-primary btn-rounded btn-icon editdata" data-id=' . $row->id . ' title="Edit" data-toggle="modal" data-target="#editModal"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';

            }
            if (Auth::user()->can('school-delete')){
                $operate .= '<a class="btn btn-xs btn-gradient-danger btn-rounded btn-icon deletedata" data-id=' . $row->id . ' data-url=' . route('web.schools.destroy', $row->id) . ' title="Delete"><i class="fa fa-trash"></i></a>';

            }

           // $data = getSettings('date_formate');

           $tempRow['id'] = $row->id;
           $tempRow['no'] = $no++;
           $tempRow['name'] =$row->name;
           $tempRow['operate'] =$operate;
           $tempRow['notes'] = $row->notes;


            $rows[] = $tempRow;
        }

        $bulkData['rows'] = $rows;
        return response()->json($bulkData);
    }



    public function edit(Schools $Schools)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        if (!Auth::user()->can('school-edit')) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return response()->json($response);

        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'name_en' => 'required',
            'notes' => 'required',
        ]);

        if ($validator->fails()) {
            $response = array(
                'error' => true,
                'message' => $validator->errors()->first()
            );
        return response()->json($response);
        }
        try {
            $Schools = Schools::find($request->id);
            $Schools->name = ['en' => $request->name_en, 'ar' => $request->name];
            $Schools->notes = $request->notes;
            $Schools->grade_id=$request->class_id;
            $Schools->save();
            $response = array(
                'error' => false,
                'message' => trans('genirale.data_update_successfully')
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
        if (!Auth::user()->can('school-delete')) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return response()->json($response);

        }

        try {
            Schools::find($id)->delete();
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
// hello
