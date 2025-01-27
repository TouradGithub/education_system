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
use App\Http\Controllers\Schools\SectionController;
use App\Http\Controllers\Schools\HomeController;
use App\Http\Controllers\Schools\AnnouncementController;
use App\Http\Controllers\Schools\FeesClassesController;
use App\Http\Controllers\Schools\SchoolAnnoucementController;

Route::group(['middleware' => ['checkNotAuth']], function () {

    Route::post('loginSchoolPage',[App\Http\Controllers\Schools\LoginController::class,'login'])->name('login.school.post');
    Route::get('loginSchool',[App\Http\Controllers\Schools\LoginController::class,'getLogin'])->name('login.school');
    Route::get('subscribe',[App\Http\Controllers\Schools\LoginController::class,'subscription'])->name('login.subscribe');


});
// .
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale().'/school',
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'authSchool','verifyUserActive']
    ], function () {


    Route::get('/home', function () {
        return view('pages.schools.dashborad');
    })->name('school.home');

    Route::prefix('students')->middleware('verifySettingSchool')->group(function () {
        Route::get('announcement-student', [StudentController::class, 'getStudentAnnoucement'])->name('student.getStudentAnnoucement');
        Route::get('show/{id}', [StudentController::class, 'show'])->name('student.show');
        Route::post('sendMessage', [StudentController::class, 'sendMessage'])->name('student.sendMessage');
        Route::get('genratePassword/{id}', [StudentController::class, 'genratePassword'])->name('student.genratePassword');
        Route::get('create', [StudentController::class, 'create'])->name('student.create');
        Route::get('index', [StudentController::class, 'index'])->name('student.index');
        Route::get('edit/{id}', [StudentController::class, 'edit'])->name('student.edit');
        Route::get('schow/inscription/{id}', [StudentController::class, 'inscription'])->name('student.schow.inscription');
        Route::post('store', [StudentController::class, 'store'])->name('student.store');
        Route::post('update/{id}', [StudentController::class, 'update'])->name('student.update');
        Route::get('Inscription/{id}', [StudentController::class, 'getPdf'])->name('inscription.pdf');
        Route::get('IdCard/{id}', [StudentController::class, 'getIdCardPage'])->name('student.idcard');

    });

    Route::get('getList', [StudentController::class, 'getList'])->name('student.getList');
    Route::resource('studentts', StudentController::class);
    Route::prefix('student/promotions')->group(function () {
        Route::get('create', [PromotionController::class, 'create'])->name('student.promotions.create');
        Route::post('store', [PromotionController::class, 'store'])->name('student.promotions.store');
        Route::get('index', [PromotionController::class, 'index'])->name('student.promotions.index');
        Route::get('show', [PromotionController::class, 'show'])->name('student.promotions.show');
        Route::get('/export-results', [PromotionController::class, 'exportResultsPDF'])->name('student.promotions.export.results.pdf');
        Route::get('/export-inscription', [PromotionController::class, 'exportInscriptionPDF'])->name('student.promotions.export.inscription.pdf');


    });

    //classes of school
    Route::resource('sections', SectionController::class);
    Route::get('getClassRoom-list', [SectionController::class, 'show']);
    Route::put('update-section-list/{id}', [SectionController::class, 'update'])->name('admin.sections.update');
    Route::get('getSection-list/{id}', [SectionController::class, 'getSections']);

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
    Route::post('setting-update', [SettingController::class,'update'])->name('setting-update');
    Route::get('student-id-card-setting', [SettingController::class,'getStudentIdCardSetting'])->name('student-id-card-setting');
    Route::post('student-id-card-setting-update', [SettingController::class,'getStudentIdCardSettingUpdate'])->name('student-id-card-setting-update');

    Route::get('edit-profile', [HomeController::class, 'editProfile'])->name('edit-profile');
    Route::post('update-profile', [HomeController::class, 'updateProfile'])->name('update-profile');
    Route::get('resetpassword', [HomeController::class, 'resetpassword'])->name('resetpassword');
    Route::get('checkPassword', [HomeController::class, 'checkPassword']);
    Route::post('changePassword', [HomeController::class, 'changePassword'])->name('changePassword');


    Route::get('get-notification/{id}', [AnnouncementController::class,'show'])->name('get-notification');

    Route::get('fees/classes', [FeesClassesController::class, 'index'])->name('fees.class.index');
    Route::get('fees/classes/getPaid/{id}', [FeesClassesController::class, 'feesPaidGetReceip'])->name('fees.class.paid.pdf');
        // Route::post('fees/classes/update', [FeesTypeController::class, 'updateFeesClass'])->name('fees.class.update');
    Route::get('fees/classes/list', [FeesClassesController::class, 'feesClassList'])->name('fees.class.list');
    Route::post('class/fees-type', [FeesClassesController::class, 'updateFeesClass'])->name('class.fees.type.update');


    Route::get('fees/paid', [FeesClassesController::class, 'feesPaidListIndex'])->name('fees.paid.index');
    Route::get('fees/paid/list', [FeesClassesController::class, 'feesPaidList'])->name('fees.paid.list');
    Route::post('fees/paid/store', [FeesClassesController::class, 'feesPaidStore'])->name('fees.paid.store');
    Route::delete('fees/paid/delete/{id}', [FeesClassesController::class, 'feesPaidDelete'])->name('fees.paid.delete');

    Route::post('fees/optional-paid/store', [FeesClassesController::class, 'optionalFeesPaidStore'])->name('fees.optional-paid.store');



    //Announcement

    Route::get('index', [SchoolAnnoucementController::class, 'index'])->name('announcement.index');
    Route::post('store', [SchoolAnnoucementController::class, 'store'])->name('announcement.store');


});
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
Route::get("loadPdf", function () {
    // return url(Storage::url(getSchool()->setting->school_logo));
    $pdf = Pdf::loadView('pages.schools.students.inscription');
    return $pdf->stream('inscription.pdf');
});
