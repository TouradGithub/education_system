<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SessionYearController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SchoolsController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeTeacherController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\TrimesterController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ChargilyPayController;
// Route::group(['middleware' => ['checkNotAuth']], function () {

    Route::get('/', [HomeController::class,'getSection'])->name('section');

    Route::get('scraper', [App\Http\Controllers\ScraperController::class, 'scraper'])->name('scraper');

    Route::get('Admin/login',[LoginController::class,'getLogin'])->name('weblogin');
    Route::post('Admin/login',[LoginController::class,'login'])->name('login');

// });



// Route::get('/', [HomeController::class, 'login']);

Route::group([ 'middleware' => ['auth','localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
                'prefix'     => LaravelLocalization::setLocale()
], function () {


    Route::get('/home', function () {
        return view('home');
    });


    Route::get('/logout', [App\Http\Controllers\Schools\LoginController::class, 'logout'])->name('logout');

    Route::resource('session-years', SessionYearController::class);


    Route::get('session_years_list', [SessionYearController::class, 'show']);

    Route::get('settings', [SettingController::class, 'index']);
    Route::post('settings', [SettingController::class, 'update']);

    Route::resource('grades', GradeController::class);
    Route::get('grades-list', [GradeController::class, 'show']);

    Route::resource('sections', SectionController::class);
    Route::get('sections-list', [SectionController::class, 'show']);
    Route::get('getSection-list/{id}', [SectionController::class, 'getSections']);
    Route::put('update-section-list/{id}', [SectionController::class, 'update'])->name('admin.sections.update');


    Route::resource('classes', ClassController::class);
    Route::get('classes-list', [ClassController::class, 'show']);
    Route::get('getClasses-list/{id}', [ClassController::class, 'getClasses']);

    Route::resource('schools', SchoolsController::class);
    Route::get('schools-list', [SchoolsController::class, 'show']);
    Route::get('schools/show/{id}', [SchoolsController::class, 'show'])->name('admin.schools.show');


    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);

    Route::resource('managements', ManagementController::class);
    Route::get('managements/edit/{id}', [ManagementController::class, 'edit'])->name('admin.managements.edit');
    Route::get('managements/show/{id}', [ManagementController::class, 'show'])->name('admin.managements.show');
    Route::get('managements/delete/{id}', [ManagementController::class, 'delete'])->name('admin.managements.delete');


    Route::get('subjects-list', [SubjectController::class, 'show']);

    // Route::resource('teachers', TeacherController::class);
    Route::get('trimesters-list', [TrimesterController::class, 'show']);
    Route::resource('trimesters', TrimesterController::class);


    Route::get('edit-profile', [App\Http\Controllers\Admin\HomeController::class, 'editProfile'])->name('edit-profile');
    Route::post('update-profile', [App\Http\Controllers\Admin\HomeController::class, 'updateProfile'])->name('update-profile');
    Route::get('resetpassword', [App\Http\Controllers\Admin\HomeController::class, 'resetpassword'])->name('resetpassword');
    Route::get('checkPassword', [App\Http\Controllers\Admin\HomeController::class, 'checkPassword']);
    Route::post('changePassword', [App\Http\Controllers\Admin\HomeController::class, 'changePassword'])->name('changePassword');


    Route::resource('announcement', AnnouncementController::class);
    Route::get('get-notification/{id}', [AnnouncementController::class,'show'])->name('get-notification');




});

Route::post('chargilypay/redirect', [ChargilyPayController::class, "redirect"])->name("chargilypay.redirect");
Route::get('chargilypay/back', [ChargilyPayController::class, "back"])->name("chargilypay.back");
Route::post('chargilypay/webhook', [ChargilyPayController::class, "webhook"])->name("chargilypay.webhook_endpoint");

// Route::get('clear', function () {
//         Artisan::call('view:clear');
//         Artisan::call('route:clear');
//         Artisan::call('config:clear');
//         Artisan::call('cache:clear');
// });

// Auth::routes();
use App\Livewire\Chat\Index;

// Route::middleware(['auth:teacher'])->group(function (){
// });

Route::group([ 'middleware' => ['auth:teacher']], function () {

    Route::get('/chat/system/{query}', Index::class)->name('chat.system');

});




