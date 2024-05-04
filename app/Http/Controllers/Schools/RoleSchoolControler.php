<?php

namespace App\Http\Controllers\Schools;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
class RoleSchoolControler extends Controller
{
    public function create(){
        $adminSchool=getRoleAdminSchool();
        $role=Role::where('name',$adminSchool->role)->where('model',"App\Models\Schools")->first();
        $permission = $role->permissions;

        return view('pages.schools.roles.create',compact('permission'));

    }
    public function index(Request $request)
    {

        $roles = Role::where('model',"App\Models\Schools")->where('model_id',getSchool()->id)->orderBy('id','DESC')->paginate(5);

        return view('pages.schools.roles.index',compact('roles'))
        ->with('i', ($request->input('page', 1) - 1) * 5);

    }
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
        ->where("role_has_permissions.role_id",$id)
        ->get();

        return view('pages.schools.roles.show',compact('role','rolePermissions'));
    }

    public function store(Request $request)
    {

          $this->validate($request, [
            //   'name' => 'required|unique:roles,name',
              'permission' => 'required',
          ]);

          $role = Role::create([
            'name' => $request->input('name'),
            'model' => "App\Models\Schools",
            'model_id' => getSchool()->id,
          ]);
          $role->syncPermissions($request->input('permission'));

          return redirect()->route('school.role.index')
          ->with('success',trans('genirale.data_store_successfully'));
    }




}
