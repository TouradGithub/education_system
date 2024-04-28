<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\Models\Acadimy;
use App\Models\User;
use App\Models\AcademyManegment;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // if (!Auth::user()->can('school-list') || !Auth::guard('acadimy')->user()->can('school-list')) {
        //     $response = array(
        //         'message' => trans('no_permission_message')
        //     );
        //     return redirect(route('home'))->withErrors($response);

        // }
        $managements = Acadimy::orderBy('id')->paginate(5);
        return view('managements.index',compact('managements'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::where('model_id',null)->pluck('name','name');
        return view('managements.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       // return $request;
        // if (!Auth::user()->can('session-year-create')) {
        //     $response = array(
        //         'error' => true,
        //         'message' => trans('no_permission_message')
        //     );
        //     return response()->json($response);
        // }
        // $request->validate([
        //     'name' => 'required',
        //     'description' => 'required',
            // 'email' => 'required|email|unique:info_acadimy,email',
            // 'password' => 'required',
        //   ],[
        //     'name.u' => trans('name_is_required_at_row'),
        // ]);

        try {

            DB::beginTransaction();

            $acadimy = Acadimy::create([
                'name' => $request->name,
                'description' => $request->description,
                'image' => $request->image,
                'adress'=>$request->adress,
                'email'=>$request->email,
            ]);
            $super_admin_role = Role::where('name', $request->input('roles'))->first();

            $academyManegment = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'role' =>  $super_admin_role->name,
                'password' => Hash::make($request->password),
                'model' => "App\Models\Acadimy",
                'model_id' => $acadimy->id,
            ]);

            $super_admin_role = Role::where('name', $request->input('roles'))->first();

            $academyManegment->assignRole($super_admin_role);
            DB::commit();
            $response = array(
                'error' => false,
                'message' => trans('data_store_successfully')
            );

        }catch (Throwable $e) {
            DB::rollback();
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
    public function show(Acadimy $management)
    {
        return $management->schools;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AcademyManegment $id)
    {
        $management = AcademyManegment::find($id)->first();
        return view('managements.edit',compact('management'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, management $management)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(management $id)
    {
        return $id;
    }
}
