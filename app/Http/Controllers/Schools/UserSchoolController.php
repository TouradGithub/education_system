<?php

namespace App\Http\Controllers\Schools;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserSchoolController extends Controller
{
    public function create(){
        if (!Auth::user()->can('school-user-create')) {
            toastr()->error(  trans('genirale.no_permission_message'), 'Error');
            return redirect()->back();
        }

        $roles = Role::where('model',"App\Models\Schools")->where('model_id',getSchool()->id)->pluck('name');
        return view('pages.schools.users.create',compact('roles'));
    }

    public function index(){
        if (!Auth::user()->can('school-user-index')) {
            toastr()->error(  trans('genirale.no_permission_message'), 'Error');
            return redirect()->back();
        }
        $schoolUsers = User::where('model',"App\Models\Schools")->where('model_id',getSchool()->id)->paginate(10);
        return view('pages.schools.users.index',compact('schoolUsers'));
    }

    public function  store(Request $request){
        if (!Auth::user()->can('school-user-create')) {
            toastr()->error(  trans('genirale.no_permission_message'), 'Error');
            return redirect()->back();
        }
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required|unique:users,phone',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $role = Role::where('name',$request->roles[0])->first();

        $schoolUser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' =>  $role->name,
            'password' => Hash::make($request->password),
            'model' => "App\Models\Schools",
            'model_id' => getSchool()->id,
        ]);

        $schoolUser->assignRole($role->id);
        return redirect()->route('school.user.index')
                        ->with('success',trans('genirale.data_store_successfully'));
    }
    public function  update(Request $request){
        if (!Auth::user()->can('school-user-edit')) {
            toastr()->error(  trans('genirale.no_permission_message'), 'Error');
            return redirect()->back();
        }
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'roles' => 'required'
        ]);
        // return $request;
        $user = User::find($request->id);

        try {
            if($request->has('password')){
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'role' =>  $request->roles[0],
                    'password' => Hash::make($request->password),
                    'model' => "App\Models\Schools",
                    'model_id' => getSchool()->id,
                ]);
            }else{
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'role' =>  $request->roles[0],
                    'model' => "App\Models\Schools",
                    'model_id' => getSchool()->id,
                ]);

            }
            $user->syncRoles($request->input('roles'));

            return redirect()->route('school.user.index')
                            ->with('success',trans('genirale.data_store_successfully'));
        } catch (\Throwable $e) {


        return redirect()->back();

        }

    }

    public function edit($id)
    {
        if (!Auth::user()->can('school-user-edit')) {
            toastr()->error(  trans('genirale.no_permission_message'), 'Error');
            return redirect()->back();
        }
      $user=  User::find($id);
// return $user;
        $roles = Role::where('name',getRoleAdminSchool())->pluck('name','name')->all();
        $userRole = $user->role;

        return view('pages.schools.users.edit',compact('user','roles','userRole'));
    }

    public function destroy($id)
    {
        if (!Auth::user()->can('school-user-delete')) {
            toastr()->error(  trans('genirale.no_permission_message'), 'Error');
            return redirect()->back();
        }
        User::find($id)->delete();
        return redirect()->route('school.user.index')
                        ->with('success',trans('genirale.data_delete_successfully'));
    }
}
