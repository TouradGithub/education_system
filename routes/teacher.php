<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Chat\Index;
use App\Livewire\Chat\Chat;
use App\Http\Controllers\Teacher\SectionController;
use App\Http\Controllers\Teacher\StudentController;
use App\Http\Controllers\Teacher\TimetableController;
use App\Http\Controllers\Teacher\AttendanceController;
use App\Http\Controllers\Teacher\HomeController;
use App\Http\Controllers\Teacher\TestController;
use App\Http\Controllers\Teacher\ExamController;
use App\Http\Controllers\Teacher\LessonController;

Route::group(['middleware' => ['checkNotAuth']], function () {

    Route::post('teacher/login',[App\Http\Controllers\Teacher\LoginController::class,'login'])->name('teacher.login');
    Route::get('teacher/login',[App\Http\Controllers\Teacher\LoginController::class,'getLogin'])->name('teacher.login');

});

Route::group(
    [
        'prefix' =>   LaravelLocalization::setLocale().'/teacher',
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath','teacherMiddleware']
    ], function () {

    Route::get('/logout', [App\Http\Controllers\Teacher\LoginController::class, 'logout'])->name('logout');

    Route::get('/home', function () {
        return view('pages.teachers.home');
    });
    Route::get('edit-profile', [HomeController::class, 'editProfile'])->name('edit-profile');
    Route::post('update-profile', [HomeController::class, 'updateProfile'])->name('update-profile');

    Route::get('resetpassword', [HomeController::class, 'resetpassword'])->name('resetpassword');
    Route::get('checkPassword', [HomeController::class, 'checkPassword']);
    Route::post('changePassword', [HomeController::class, 'changePassword'])->name('changePassword');


    Route::resource('timetable', TimetableController::class);
    Route::get('gettimetablebyclass', [TimetableController::class, 'gettimetablebyclass']);

    Route::resource('attendance', AttendanceController::class);
    Route::get('student-list', [AttendanceController::class, 'show']);

    Route::resource('sections', SectionController::class);
    Route::get('teacher-section-list', [SectionController::class,'show']);

    Route::resource('students', StudentController::class);
    Route::get('teacher-student-list', [StudentController::class,'show']);
    Route::get('index-student-teacher/{id}', [StudentController::class,'index'])->name('student.index.teacher');

    Route::resource('tests', TestController::class);
    Route::get('test-student-list', [TestController::class,'show']);

    Route::resource('exams', ExamController::class);
    Route::get('exam-student-list', [ExamController::class,'show']);
    Route::get('get-subject-list', [ExamController::class,'getSubjectByTeacher']);
    Route::get('get-subject-list', [ExamController::class,'getSubjectByTeacher']);
    Route::get('chat', Index::class)->name('chat.index');
    Route::post('chat', [Index::class,'sendMessage'] )->name('sendMessage.chat');
    // Route::get('message/{id}', Index::class)->name('chat.message');

    Route::get('message/{id}', [HomeController::class, 'message'])->name('message.index');
    Route::get('teacher-get-list', [HomeController::class, 'getTeachersOfSchool'])->name('getTeachersOfSchool.index');
    // Route::get('/chat/{query}',Chat::class)->name('chat');

    Route::get('create/{id}', [LessonController::class, 'create'])->name('lesson.create');
    Route::get('list-lessons', [LessonController::class, 'show'])->name('lesson.list-lesson');
    Route::get('lesson-delete/{id}', [LessonController::class, 'destroy'])->name('lesson.lesson-delete');
    Route::post('lesson-edit/{id}', [LessonController::class, 'update'])->name('lesson.edit');
    Route::post('store', [LessonController::class, 'store'])->name('lesson.store');



});
