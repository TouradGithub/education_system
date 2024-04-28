<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Schools\Student\StudentController;
use App\Http\Controllers\Schools\Student\PromotionController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\SubjectTeacherController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\Schools\UserSchoolController;
use App\Http\Controllers\Schools\RoleSchoolControler;
use App\Http\Controllers\Schools\SettingController;
use App\Http\Controllers\Schools\HomeController;
use App\Http\Controllers\Schools\AnnouncementController;

Route::group(['middleware' => ['checkNotAuth']], function () {

    Route::post('loginSchool',[App\Http\Controllers\Schools\LoginController::class,'login'])->name('login.school');
    Route::get('loginSchool',[App\Http\Controllers\Schools\LoginController::class,'getLogin'])->name('login.school');

});
// .
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale().'/school',
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'authSchool','verifyUserActive']
    ], function () {


    Route::get('/home', function () {
        return view('pages.schools.dashborad');
    });

    Route::prefix('students')->group(function () {
        Route::get('create', [StudentController::class, 'create'])->name('student.create');
        Route::get('index', [StudentController::class, 'index'])->name('student.index');
        Route::get('edit/{id}', [StudentController::class, 'edit'])->name('student.edit');
        Route::post('store', [StudentController::class, 'store'])->name('student.store');
        Route::post('update/{id}', [StudentController::class, 'update'])->name('student.update');

    });

    Route::get('getList', [StudentController::class, 'getList'])->name('student.getList');

    Route::resource('studentts', StudentController::class);

    Route::prefix('student/promotions')->group(function () {
        Route::get('create', [PromotionController::class, 'create'])->name('student.promotions.create');
        Route::post('store', [PromotionController::class, 'store'])->name('student.promotions.store');
        Route::get('index', [PromotionController::class, 'index'])->name('student.promotions.index');

    });


    Route::resource('subjects', SubjectController::class);
    Route::get('subjects-list', [SubjectController::class, 'show']);

    Route::resource('subject-teachers', SubjectTeacherController::class);
    Route::get('subject-teachers-list', [SubjectTeacherController::class, 'show']);
    Route::get('get-subject-by-class/{id}', [SubjectTeacherController::class, 'getSubjectByClass'])->name('get-subject-by-class');


    Route::resource('teachers', TeacherController::class);
    Route::get('teacher_list', [TeacherController::class, 'show']);

    Route::resource('attendance', AttendanceController::class);
    Route::get('view-attendance', [AttendanceController::class, 'view'])->name("attendance.view");
    Route::get('student-attendance-list', [AttendanceController::class, 'attendance_show']);
    Route::get('getAttendanceData', [AttendanceController::class, 'getAttendanceData']);
    Route::get('student-list', [AttendanceController::class, 'show']);
    Route::get('getStudent-list', [AttendanceController::class, 'getStudentAttendance']);

    //timetables
    Route::resource('timetable', TimetableController::class);
    Route::get('timetable-list', [TimetableController::class, 'show']);
    Route::get('checkTimetable', [TimetableController::class, 'checkTimetable']);
    Route::get('getTimetable-list', [TimetableController::class, 'getTimetable']);

    Route::get('get-subject-by-class-section', [TimetableController::class, 'getSubjectByClassSection']);
    Route::get('getteacherbysubject', [TimetableController::class, 'getteacherbysubject']);

    Route::get('gettimetablebyclass', [TimetableController::class, 'gettimetablebyclass'])->name('get.timetable.class');
    Route::get('gettimetablebyteacher', [TimetableController::class, 'gettimetablebyteacher']);
    Route::get('get-timetable-by-subject-teacher-class', [TimetableController::class, 'getTimetableBySubjectTeacherClass']);

    Route::get('class-timetable', [TimetableController::class, 'class_timetable']);
    Route::get('teacher-timetable', [TimetableController::class, 'teacher_timetable']);


    Route::get('user-create', [UserSchoolController::class, 'create'])->name('user.create');
    Route::get('user-index', [UserSchoolController::class, 'index'])->name('user.index');
    Route::get('user-edit/{id}', [UserSchoolController::class, 'edit'])->name('user.edit');
    Route::get('user-show', [UserSchoolController::class, 'show'])->name('user.show');
    Route::post('user-store', [UserSchoolController::class, 'store'])->name('user.store');
    Route::post('user-update/{id}', [UserSchoolController::class, 'update'])->name('user.update');

    Route::get('role-create', [RoleSchoolControler::class, 'create'])->name('role.create');
    Route::get('role-index', [RoleSchoolControler::class, 'index'])->name('role.index');
    Route::get('role-edit/{id}', [RoleSchoolControler::class, 'edit'])->name('role.edit');
    Route::get('role-show/{id}', [RoleSchoolControler::class, 'show'])->name('role.show');
    Route::post('role-store', [RoleSchoolControler::class, 'store'])->name('role.store');
    Route::post('role-update/{id}', [RoleSchoolControler::class, 'update'])->name('role.update');

    Route::resource('tests', TestController::class);
    Route::get('test-student-list', [TestController::class,'show']);

    Route::resource('exams', ExamController::class);
    Route::get('exam-student-list', [ExamController::class,'show']);

    Route::get('setting-index', [SettingController::class,'index'])->name('setting-index');

    Route::get('edit-profile', [HomeController::class, 'editProfile'])->name('edit-profile');
    Route::post('update-profile', [HomeController::class, 'updateProfile'])->name('update-profile');
    Route::get('resetpassword', [HomeController::class, 'resetpassword'])->name('resetpassword');
    Route::get('checkPassword', [HomeController::class, 'checkPassword']);
    Route::post('changePassword', [HomeController::class, 'changePassword'])->name('changePassword');


    Route::get('get-notification/{id}', [AnnouncementController::class,'show'])->name('get-notification');
});
