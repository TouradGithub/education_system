<?php

use App\Models\Grade;
use App\Models\Language;
use App\Models\Schools;
use App\Models\Settings;
use App\Models\Acadimy;
use App\Models\SessionYear;
use App\Models\Student;
use App\Models\IdcardSetting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

function getSettings($type = '')
{
    $settingList = array();
    if ($type == '') {
        $setting = Settings::get();
    } else {
        $setting = Settings::where('type', $type)->get();
    }
    foreach ($setting as $row) {
        $settingList[$row->type] = $row->message;
    }
    return $settingList;
}




function getYearNow(){
    return SessionYear::where('default',1)->first();
}

function settingIdCard(){
    return IdcardSetting::where('school_id',getSchool()->id)->first();
}

function getMonth($id){
    $months = [
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December',
    ];
    return $months[$id];
}
function getMonths(){
    return $months = [
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December',
    ];
}



function getTimezoneList()
{
    static $timezones = null;

    if ($timezones === null) {
        $list = DateTimeZone::listAbbreviations();
        $idents = DateTimeZone::listIdentifiers();

        $data = $offset = $added = array();
        foreach ($list as $abbr => $info) {
            foreach ($info as $zone) {
                if (!empty($zone['timezone_id']) and !in_array($zone['timezone_id'], $added) and in_array($zone['timezone_id'], $idents)) {
                    $z = new DateTimeZone($zone['timezone_id']);
                    $c = new DateTime('', $z);
                    $zone['time'] = $c->format('H:i a');
                    $offset[] = $zone['offset'] = $z->getOffset($c);
                    $data[] = $zone;
                    $added[] = $zone['timezone_id'];
                }
            }
        }

        array_multisort($offset, SORT_ASC, $data);
        $i = 0;
        $temp = array();
        foreach ($data as $key => $row) {
            $temp[0] = $row['time'];
            $temp[1] = formatOffset($row['offset']);
            $temp[2] = $row['timezone_id'];
            $timezones[$i++] = $temp;
        }
    }
    return $timezones;
}

function formatOffset($offset)
{
    $hours = $offset / 3600;
    $remainder = $offset % 3600;
    $sign = $hours > 0 ? '+' : '-';
    $hour = (int)abs($hours);
    $minutes = (int)abs($remainder / 60);

    if ($hour == 0 and $minutes == 0) {
        $sign = ' ';
    }
    return $sign . str_pad($hour, 2, '0', STR_PAD_LEFT) . ':' . str_pad($minutes, 2, '0');
}

function flattenMyModel($model)
{
    $modelArr = $model->toArray();
    $data = [];
    array_walk_recursive($modelArr, function ($item, $key) use (&$data) {
        $data[$key] = $item;
    });
    return $data;
}

function getRoleAdminSchool(){

    $user= User::where('model',"App\Models\Schools")->where('model_id',getSchool()->id)->where('is_admin_school',1)->first();
    return $user;
}

function getSchool(){

    if(Auth::guard('teacher')->check()){
        $user=Auth::guard('teacher')->user();
        return $user->school;
    }
    elseif(Auth::guard('web')->check()){
        $user=Auth::guard('web')->user();
        return $user->school();
    }

    // Schools::find(Auth::user()->id);
}
function getAcadimic($id){
    return Acadimy::find($id);
}
function getRollNumber($section_id){

 return   Student::InStudent()->where('section_id',$section_id)->count();

}
