<?php

namespace App\Http\Controllers\Teacher;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Teacher;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\Conversation;
use App\Models\Message;
class HomeController extends Controller
{
    public function editProfile()
    {
        $admin_data = Auth::guard('teacher')->user();
        return view('pages.teachers.update_profile', compact('admin_data'));
    }
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile' => 'required|digits:10',
            'gender' => 'required',
            'dob' => 'required',
            'email' => 'required|email',
            'image' => 'nullable|mimes:jpeg,png,jpg|image|max:5048',
            'current_address' => 'required',
            'permanent_address' => 'required',
        ]);
        if ($validator->fails()) {
            $response = array(
                'error' => true,
                'message' => $validator->errors()->first()
            );
            return response()->json($response);
        }
        try {
            $user_db = Teacher::find($request->id);
            $user_db->first_name = $request->first_name;
            $user_db->last_name = $request->last_name;
            $user_db->mobile = $request->mobile;
            $user_db->gender = $request->gender;
            $user_db->dob = date('Y-m-d', strtotime($request->dob));
            $user_db->email = $request->email;
            $user_db->current_address = $request->current_address;
            $user_db->permanent_address = $request->permanent_address;
            if (!empty($request->image)) {
                if (Storage::disk('public')->exists($user_db->getRawOriginal('image'))) {
                    Storage::disk('public')->delete($user_db->getRawOriginal('image'));
                }

                $image = $request->image;
                $file_name = time() . '-' . $image->getClientOriginalName();
                $file_path = 'teachers/' . $file_name;
                $destinationPath = storage_path('app/public/teachers');
                $image->move($destinationPath, $file_name);

                $user_db->image = $file_path;
            }
            $user_db->save();

            return redirect()->route('teacher.edit-profile')->with('success', __('genirale.data_update_successfully'));
        } catch (\Throwable $e) {
            return redirect()->route('teacher.edit-profile')->with('error', trans('genirale.error_occurred'));
        }
    }

    public function resetpassword()
    {
        return view('pages.teachers.reset_password');
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
        $id = Auth::guard('teacher')->id();

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);

        try {
            $teacher = Teacher::find($id);

            if (!$teacher) {
                return response()->json([
                    'error' => true,
                    'message' => trans('genirale.error_occurred')
                ]);
            }

            if (!Hash::check($request->old_password, $teacher->password)) {
                return response()->json([
                    'error' => true,
                    'message' => trans('genirale.error_occurred')
                ]);
            }

            $teacher->password = Hash::make($request->new_password);
            $teacher->save();

            $response = [
                'error' => false,
                'message' => trans('genirale.data_update_successfully')
            ];
        } catch (\Throwable $e) {
            $response = [
                'error' => true,
                'message' => $e->getMessage()
                // trans('general.error_occurred')
            ];
        }

        return response()->json($response);
    }
    public function message($userId){


        $authenticatedUserId = Auth::guard('teacher')->id();

        # Check if conversation already exists
        $existingConversation = Conversation::where(function ($query) use ($authenticatedUserId, $userId) {
                  $query->where('sender_id', $authenticatedUserId)
                      ->where('receiver_id', $userId);
                  })
              ->orWhere(function ($query) use ($authenticatedUserId, $userId) {
                  $query->where('sender_id', $userId)
                      ->where('receiver_id', $authenticatedUserId);
              })->first();

        if ($existingConversation) {
            # Conversation already exists, redirect to existing conversation
            return redirect()->route('teacher.chat.index', ['query' => $existingConversation->id]);
        }

        # Create new conversation
        $createdConversation = Conversation::create([
            'sender_id' => $authenticatedUserId,
            'receiver_id' => $userId,
            'school_id' => getSchool()->id,
            'session_year' =>  getYearNow()->id,
        ]);

        //   return redirect()->route('teacher.chat.index', ['query' => $createdConversation->id]);

    }
    public function getTeachersOfSchool(Request $request)
    {
        $id = Auth::guard('teacher')->id();

        $sql =Teacher::where('school_id', getSchool()->id)
        ->where('id', '!=', $id);
        $res = $sql->get();

        $bulkData = array();
        $rows = array();
        $tempRow = array();
        $no = 1;
        foreach ($res as $row) {
            $operate = '';

            $tempRow['id'] = $row->id;
            $tempRow['first_name'] =$row->first_name;
            $tempRow['last_name'] =$row->last_name;
            $operate .= '<a class="btn btn-primary" href="'.route('web.chat.system',$row->id).'" title="">' . __('genirale.Message') . '</a>';
            $tempRow['gender'] =$row->gender;
            $tempRow['operate'] =$operate;
            $rows[] = $tempRow;

        }

            $bulkData['rows'] = $rows;
            return response()->json($bulkData);
    }
}
