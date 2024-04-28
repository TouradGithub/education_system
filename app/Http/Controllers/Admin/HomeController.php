<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class HomeController extends Controller
{
    public function editProfile()
    {
        $admin_data = Auth::user();
        return view('update_profile', compact('admin_data'));
    }
    public function updateProfile(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ]);
        if ($validator->fails()) {
            $response = array(
                'error' => true,
                'message' => $validator->errors()->first()
            );
            return redirect()->route('school.edit-profile')->with('error',  $response);

        }
        try {
            $user_db = User::find($request->id);
            $user_db->name = $request->name;
            $user_db->phone = $request->phone;
            $user_db->email = $request->email;

            if (!is_null($user_db->image)) {
                if (Storage::disk('public')->exists($user_db->image)) {
                    Storage::disk('public')->delete($user_db->image);
                }

                $image = $request->image;
                $file_name = time() . '-' . $image->getClientOriginalName();
                $file_path = 'users/'. $file_name;
                $destinationPath = storage_path('app/public/users');
                $image->move($destinationPath, $file_name);

                $user_db->image = $file_path;
            }
            $user_db->save();

            return redirect()->route('web.edit-profile')->with('success', __('genirale.data_update_successfully'));
        } catch (\Throwable $e) {
            return redirect()->route('school.edit-profile')->with('error', trans('genirale.error_occurred'));
        }
    }

    public function resetpassword()
    {
        return view('reset_password');
    }

    public function checkPassword(Request $request)
    {
        // $old_password = $request->old_password;
        // $password = User::where('id', Auth::id())->first();
        // if (Hash::check($old_password, $password->password)) {
        //     return response()->json(1);
        // } else {
        //     return response()->json(0);
        // }
    }

    public function changePassword(Request $request)
    {
        $id = Auth::id();

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);

        try {
            $user_db = User::find($id);

            if (!$user_db) {
                return response()->json([
                    'error' => true,
                    'message' => trans('genirale.error_occurred')
                ]);
            }

            if (!Hash::check($request->old_password, $user_db->password)) {
                return response()->json([
                    'error' => true,
                    'message' => trans('genirale.error_occurred')
                ]);
            }

            $user_db->password = Hash::make($request->new_password);
            $user_db->save();

            $response = [
                'error' => false,
                'message' => trans('genirale.data_update_successfully')
            ];
        } catch (\Throwable $e) {
            $response = [
                'error' => true,
                // 'message' => $e->getMessage()
                trans('general.error_occurred')
            ];
        }

        return response()->json($response);
    }


}
