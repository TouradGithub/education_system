<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
class RoleController extends Controller
{


    public function index(Request $request)
    {
        if (!Auth::user()->can('role-list')) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return redirect()->back();

        }
        $roles = Role::where('model','App\Models\Admin')->orderBy('id','DESC')->paginate(5);
        return view('roles.index',compact('roles'))
        ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        if (!Auth::user()->can('role-create')) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return redirect()->back();

        }
        $permission = Permission::get();
        return view('roles.create',compact('permission'));
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        if (!Auth::user()->can('role-create')) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return redirect()->back();

        }
        // return $request;
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);
        // return "ok";

        $role = Role::create(['name' => $request->input('name'),'model'=>'App\Models\Admin']);
        $role->syncPermissions($request->input('permission'));

        return redirect()->route('web.roles.index')
        ->with('success',trans('genirale.data_store_successfully'));
    }
    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        if (!Auth::user()->can('role-show')) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return redirect()->back();

        }
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
        ->where("role_has_permissions.role_id",$id)
        ->get();

        return view('roles.show',compact('role','rolePermissions'));
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        if (!Auth::user()->can('role-edit')) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return redirect()->back();

        }
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
        ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
        ->all();

        return view('roles.edit',compact('role','permission','rolePermissions'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id)
    {
        if (!Auth::user()->can('role-edit')) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return redirect()->back();

        }
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();

        $role->syncPermissions($request->input('permission'));

        return redirect()->route('web.roles.index')
        ->with('success',trans('data_update_successfully'));
    }
    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        if (!Auth::user()->can('role-delete')) {
            $response = array(
                'message' => trans('genirale.no_permission_message')
            );
            return redirect()->back();

        }
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('roles.index')
        ->with('success',trans('data_delete_successfully'));
    }
}
