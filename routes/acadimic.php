<?php


use Illuminate\Support\Facades\Route;

Route::get('loginPage',[App\Http\Controllers\Acadimy\LoginController::class,'getLogin'])->name('getlogin');
Route::post('login',[App\Http\Controllers\Acadimy\LoginController::class,'login'])->name('login');
// Route::group(['middleware' => ['auth']], function () {
Route::get('/home', function () {

    return view('pages.acadimic.dashborad');

});
// });
