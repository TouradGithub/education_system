<?php


use Illuminate\Support\Facades\Route;

Route::get('login',[App\Http\Controllers\Acadimy\LoginController::class,'getLogin'])->name('login');
Route::post('login',[App\Http\Controllers\Acadimy\LoginController::class,'login'])->name('login');
// Route::group(['middleware' => ['auth']], function () {
Route::get('/home', function () {

    return view('pages.acadimic.dashborad');

});
// });
