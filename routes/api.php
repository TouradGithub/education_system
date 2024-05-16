<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\StudentApiController;
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



