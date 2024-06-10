<?php

namespace App\Http\Controllers\Schools;
use App\Models\SessionYear;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
class SettingController extends Controller
{
    public function index()
    {
        if (!Auth::user()->can('school-general_settings-update')) {
            $response = array(
                'message' => trans('no_permission_message')
            );
            return redirect(route('school.school.home'))->withErrors($response);
        }

        $settings = getSettings();

        return view('pages.schools.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        if (!Auth::user()->can('school-general_settings-update')) {
            $response = array(
                'message' => trans('no_permission_message')
            );
            return redirect(route('school.school.home'))->withErrors($response);
        }




        try {
            $setting = getSchool()->setting;
            if($setting){

                $setting->school_name= $request->school_name;
                $setting->school_email= $request->school_email;
                $setting->school_mobile= $request->school_mobile;
                $setting->school_description= $request->school_description;
                $setting->school_address= $request->school_address;

                if ($request->hasFile('logo')) {
                    // return Storage::disk('public')->exists($st->logo);
                    if ( $setting->school_logo && Storage::disk('public')->exists($setting->school_logo)) {
                        Storage::disk('public')->delete($setting->school_logo);
                    }
                    $image = $request->file('logo');
                    $file_name = time() . '-' . $image->getClientOriginalName();
                    $file_path = 'schools/' . $file_name;
                    $destinationPath = storage_path('app/public/schools');
                    $image->move($destinationPath, $file_name);
                    $setting->school_logo = $file_path;
                }
                $setting->save();
            }

        } catch (Throwable $e) {
            $response = array(
                'error' => true,
                'message' => trans('genirale.error_occurred'),
                'data' => $e
            );
        }
        
         return redirect()->back()->with('success', trans('genirale.data_update_successfully'));
    }
}
