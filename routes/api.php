<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\StudentApiController;
use App\Http\Controllers\Api\ParentApiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

    Route::group(['prefix' => 'student'], function () {


        Route::post('login', [StudentApiController::class, 'login']);
        Route::middleware('auth:sanctum')->get('logout', [StudentApiController::class, 'logout']);
        Route::middleware('auth:sanctum')->get('section', [StudentApiController::class, 'section']);
        Route::middleware('auth:sanctum')->get('studentInfo', [StudentApiController::class, 'studentInfo']);
        Route::middleware('auth:sanctum')->get('studentAccount', [StudentApiController::class, 'studentAccount']);
        Route::middleware('auth:sanctum')->get('studentParent', [StudentApiController::class, 'studentParent']);
        Route::middleware('auth:sanctum')->get('studentSubject', [StudentApiController::class, 'studentSubject']);
        Route::middleware('auth:sanctum')->get('studentSchool', [StudentApiController::class, 'studentSchool']);
        Route::middleware('auth:sanctum')->get('getAcadimicYear', [StudentApiController::class, 'getAcadimicYear']);
        Route::middleware('auth:sanctum')->get('getTimetable', [StudentApiController::class, 'getTimetable']);
        Route::middleware('auth:sanctum')->get('getExams', [StudentApiController::class, 'getExams']);
        Route::middleware('auth:sanctum')->get('getTests', [StudentApiController::class, 'getTests']);
        Route::middleware('auth:sanctum')->get('getTrimesters', [StudentApiController::class, 'getTrimesters']);
        Route::middleware('auth:sanctum')->get('getLessons', [StudentApiController::class, 'getLessons']);

        Route::middleware('auth:sanctum')->post('getAttandance', [StudentApiController::class, 'getAttandance']);
        Route::middleware('auth:sanctum')->get('getSettings', [StudentApiController::class, 'getSettings']);
        Route::middleware('auth:sanctum')->get('getAnnouncementSchool', [StudentApiController::class, 'getAnnouncementSchool']);
        Route::middleware('auth:sanctum')->get('getRecommandation', [StudentApiController::class, 'getRecommandation']);

    });


 Route::group(['prefix' => 'parent'], function () {


    Route::post('login', [ParentApiController::class, 'login']);
    Route::middleware('auth:sanctum')->get('getStudents', [ParentApiController::class, 'getStudents']);
    Route::middleware('auth:sanctum')->get('getParentInfo', [ParentApiController::class, 'getParentInfo']);
    Route::middleware('auth:sanctum')->post('parentSubject', [ParentApiController::class, 'parentSubject']);
    Route::middleware('auth:sanctum')->post('parentChildLesson', [ParentApiController::class, 'getLessons']);
    Route::middleware('auth:sanctum')->post('parentChildTeachers', [ParentApiController::class, 'getTeachers']);
    Route::middleware('auth:sanctum')->post('parentChildAttendance', [ParentApiController::class, 'getAttandance']);
    Route::middleware('auth:sanctum')->post('parentChildTimeTable', [ParentApiController::class, 'getTimetable']);
    Route::middleware('auth:sanctum')->post('parentChildSection', [ParentApiController::class, 'getSection']);


    Route::middleware('auth:sanctum')->post('parentChildExams', [ParentApiController::class, 'getExams']);
    Route::middleware('auth:sanctum')->post('parentChildTests', [ParentApiController::class, 'getTests']);
    Route::middleware('auth:sanctum')->get('getTrimesters', [ParentApiController::class, 'getTrimesters']);
    Route::middleware('auth:sanctum')->post('parentgetAnnouncements', [ParentApiController::class, 'getAnnouncements']);



    // Route::middleware('auth:sanctum')->get('section', [ParentApiController::class, 'section']);
    // Route::middleware('auth:sanctum')->get('studentInfo', [ParentApiController::class, 'studentInfo']);
    // Route::middleware('auth:sanctum')->get('studentAccount', [ParentApiController::class, 'studentAccount']);
    // Route::middleware('auth:sanctum')->get('studentParent', [ParentApiController::class, 'studentParent']);
    // Route::middleware('auth:sanctum')->get('studentSubject', [ParentApiController::class, 'studentSubject']);
    // Route::middleware('auth:sanctum')->get('studentSchool', [ParentApiController::class, 'studentSchool']);
    // Route::middleware('auth:sanctum')->get('getAcadimicYear', [ParentApiController::class, 'getAcadimicYear']);
    // Route::middleware('auth:sanctum')->get('getTimetable', [ParentApiController::class, 'getTimetable']);
    // Route::middleware('auth:sanctum')->get('getExams', [ParentApiController::class, 'getExams']);
    // Route::middleware('auth:sanctum')->get('getTests', [ParentApiController::class, 'getTests']);
    // Route::middleware('auth:sanctum')->get('getTrimesters', [ParentApiController::class, 'getTrimesters']);
    // Route::middleware('auth:sanctum')->get('getLessons', [ParentApiController::class, 'getLessons']);

    // Route::middleware('auth:sanctum')->post('getAttandance', [ParentApiController::class, 'getAttandance']);
    // Route::middleware('auth:sanctum')->get('getSettings', [ParentApiController::class, 'getSettings']);
    // Route::middleware('auth:sanctum')->get('getAnnouncementSchool', [ParentApiController::class, 'getAnnouncementSchool']);
    // Route::middleware('auth:sanctum')->get('getRecommandation', [ParentApiController::class, 'getRecommandation']);

 });



