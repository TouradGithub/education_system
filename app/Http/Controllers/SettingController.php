<?php

namespace App\Http\Controllers;
use App\Models\SessionYear;
use App\Models\Settings;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        // if (!Auth::user()->can('setting-create')) {
        //     $response = array(
        //         'message' => trans('no_permission_message')
        //     );
        //     return redirect(route('home'))->withErrors($response);
        // }

        $settings = getSettings();
        $getDateFormat = getDateFormat();
        $getTimezoneList = getTimezoneList();
        $getTimeFormat = getTimeFormat();

        $session_year = SessionYear::orderBy('id', 'desc')->get();
        // $language = Language::select('id', 'name')->orderBy('id', 'desc')->get();
        return view('settings.index', compact('settings', 'getDateFormat', 'getTimezoneList', 'getTimeFormat', 'session_year'));
    }

    public function update(Request $request)
    {
        // if (!Auth::user()->can('setting-create')) {
        //     $response = array(
        //         'message' => trans('no_permission_message')
        //     );
        //     return redirect(route('home'))->withErrors($response);
        // }

        $request->validate([
            'school_name' => 'required|max:255',
            'school_email' => 'required|email',
            'school_phone' => 'required',
            'school_address' => 'required',
            'time_zone' => 'required',
            'theme_color' => 'required',
            'session_year' => 'required',
            'school_tagline' => 'required',
            'online_payment' => 'required|in:0,1'
        ]);

        $settings = [
            'school_name', 'school_email', 'school_phone', 'school_address',
            'time_zone', 'date_formate', 'time_formate', 'theme_color', 'session_year', 'school_tagline' ,'online_payment'
        ];
        try {
            foreach ($settings as $row) {
                if (Settings::where('type', $row)->exists()) {
                    if ($row == 'session_year') {
                        $get_id = Settings::select('message')->where('type', 'session_year')->pluck('message')->first();

                        $old_year = SessionYear::find($get_id);
                        $old_year->default = 0;
                        $old_year->save();

                        $session_year = SessionYear::find($request->$row);
                        $session_year->default = 1;
                        $session_year->save();
                    }

                    // removing the double unnecessary double quotes in school name
                    if ($row == 'school_name') {
                        $data = [
                            'message' => str_replace('"', '', $request->$row)
                        ];
                    }else{
                        $data = [
                            'message' => $request->$row
                        ];
                    }
                    Settings::where('type', $row)->update($data);
                } else {
                    $setting = new Settings();
                    $setting->type = $row;
                    $setting->message = $row == 'school_name' ? str_replace('"', '', $request->$row) : $request->$row;
                    $setting->save();
                }
            }

            // for online payment data
            if (Settings::where('type', 'online_payment')->exists()) {
                $data = [
                    'message' => $request->online_payment
                ];
                Settings::where('type', 'online_payment')->update($data);
            } else {
                $setting = new Settings();
                $setting->type = 'online_payment';
                $setting->message = $request->online_payment;
                $setting->save();
            }
            // end of online payment data

            if ($request->hasFile('logo1')) {
                if (Settings::where('type', 'logo1')->exists()) {
                    $get_id = Settings::select('message')->where('type', 'logo1')->pluck('message')->first();
                    if (Storage::disk('public')->exists($get_id)) {
                        Storage::disk('public')->delete($get_id);
                    }
                    $data = [
                        'message' => $request->file('logo1')->store('logo', 'public')
                    ];
                    Settings::where('type', 'logo1')->update($data);
                } else {
                    $setting = new Settings();
                    $setting->type = 'logo1';
                    $setting->message = $request->file('logo1')->store('logo', 'public');
                    $setting->save();
                }
            }
            if ($request->hasFile('logo2')) {
                if (Settings::where('type', 'logo2')->exists()) {
                    $get_id = Settings::select('message')->where('type', 'logo2')->pluck('message')->first();
                    if (Storage::disk('public')->exists($get_id)) {
                        Storage::disk('public')->delete($get_id);
                    }
                    $data = [
                        'message' => $request->file('logo2')->store('logo', 'public')
                    ];
                    Settings::where('type', 'logo2')->update($data);
                } else {
                    $setting = new Settings();
                    $setting->type = 'logo2';
                    $setting->message = $request->file('logo2')->store('logo', 'public');
                    $setting->save();
                }
            }
            if ($request->hasFile('favicon')) {
                if (Settings::where('type', 'favicon')->exists()) {
                    $get_id = Settings::select('message')->where('type', 'favicon')->pluck('message')->first();
                    if (Storage::disk('public')->exists($get_id)) {
                        Storage::disk('public')->delete($get_id);
                    }
                    $data = [
                        'message' => $request->file('favicon')->store('logo', 'public')
                    ];
                    Settings::where('type', 'favicon')->update($data);
                } else {
                    $setting = new Settings();
                    $setting->type = 'favicon';
                    $setting->message = $request->file('favicon')->store('logo', 'public');
                    $setting->save();
                }
            }

            $logo1 = Settings::select('message')->where('type', 'logo1')->pluck('message')->first();
            $logo2 = Settings::select('message')->where('type', 'logo2')->pluck('message')->first();
            $favicon = Settings::select('message')->where('type', 'favicon')->pluck('message')->first();
            $app_name = Settings::select('message')->where('type', 'school_name')->pluck('message')->first();
            $timezone = Settings::select('message')->where('type', 'time_zone')->pluck('message')->first();

           
        } catch (Throwable $e) {
            $response = array(
                'error' => true,
                'message' => trans('error_occurred'),
                'data' => $e
            );
        }
       // return response()->json($response);
         return redirect()->back()->with('success', trans('data_update_successfully'));
    }
}
