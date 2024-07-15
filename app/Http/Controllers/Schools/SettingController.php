<?php

namespace App\Http\Controllers\Schools;
use App\Models\SessionYear;
use App\Models\Settings;
use App\Models\IdcardSetting;
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
    public function getStudentIdCardSetting(){
        return view('pages.schools.idCardsettings');
    }

    public function getStudentIdCardSettingUpdate(Request $request)
    {
        try {

            $validatedData = $request->validate([
                'country_text'             => 'required|string',
                'country_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'header_color'             => 'nullable|string',
                'header_text_color'        => 'nullable|string',
                'signature' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'layout_type'              => 'nullable|string',
                'profile_image_style'      => 'required|string',
                'card_width'               => 'required|string',
                'card_height'              => 'required|string',
                'student_id_card_fields'   => 'required|array',
                'student_id_card_fields.*' => 'required|string',
            ]);

            // Retrieve the existing IdcardSetting or create a new one if it doesn't exist
            $idcardsettings = IdcardSetting::where('school_id', getSchool()->id)->first();
            if (!$idcardsettings) {
                $idcardsettings = new IdcardSetting();
                $idcardsettings->school_id = getSchool()->id;
            }

            // Handle the country_image upload
            if ($request->hasFile('country_image')) {

                if (Storage::disk('public')->exists($idcardsettings->country_image)) {
                    Storage::disk('public')->delete($idcardsettings->country_image);
                }
                $image = $request->file('country_image');
                $file_name = time() . '-' . $image->getClientOriginalName();
                $file_path = 'idcardsettingcountry_image/' . $file_name;

                $destinationPath = storage_path('app/public/idcardsetting');
                $image->move($destinationPath, $file_name);


                $idcardsettings->country_image =  $file_name;
            }

            // Handle the background_image upload
            if ($request->hasFile('background_image')) {
                if (Storage::disk('public')->exists($idcardsettings->background_image)) {
                    Storage::disk('public')->delete($idcardsettings->background_image);
                }
                $image = $request->file('background_image');
                $file_name = time() . '-' . $image->getClientOriginalName();
                $file_path = 'idcardsettingbackground_image/' . $file_name;

                $destinationPath = storage_path('app/public/idcardsetting');
                $image->move($destinationPath, $file_name);

                $idcardsettings->background_image =  $file_name;
            }

            // Handle the signature upload
            if ($request->hasFile('signature')) {
                if (Storage::disk('public')->exists($idcardsettings->signature)) {
                    Storage::disk('public')->delete($idcardsettings->signature);
                }
                $image = $request->file('signature');
                $file_name = time() . '-' . $image->getClientOriginalName();
                $file_path = 'idcardsettingsignature/' . $file_name;

                $destinationPath = storage_path('app/public/idcardsetting');
                $image->move($destinationPath, $file_name);


                $idcardsettings->signature = $file_name;
            }

            // Update the idcardsettings with the validated data
            $idcardsettings->country_text = $request->country_text;
            $idcardsettings->header_color = $request->header_color;
            $idcardsettings->header_text_color = $request->header_text_color;
            $idcardsettings->layout_type = $request->layout_type;
            $idcardsettings->profile_image_style = $request->profile_image_style;
            $idcardsettings->card_width = $request->card_width;
            $idcardsettings->card_height = $request->card_height;
            $idcardsettings->student_id_card_fields =  json_encode($request->student_id_card_fields);

            // Save the idcardsettings to the database
            $idcardsettings->save();


            return redirect()->back()->with('success', trans('genirale.data_update_successfully'));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', trans('genirale.error_occurred'));
        }
    }

}
