<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// $users='';


// if(Auth::guard('teacher')->id()){
//     $id=Auth::guard('teacher')->id();
//     $users='teachers'.$id;
// }
// if(Auth::guard('web')->id()){
//     $id=Auth::guard('web')->id();
//     $users='users'.$id;
// }
// return ['public'.$user.$id];
// Broadcast::channel('private-teachers.1', function ($user, $id) {
//     // return Auth::guard('teacher')->id();
//     return true;
//     // return (int) $user->id === (int) $id;
// });
