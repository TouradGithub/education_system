<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Teacher;
use App\Models\StudentAcount;
use App\Models\MyParent;

class ResetAllPasswords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'password:reset-all
                          {--password=12345678 : كلمة المرور الجديدة لجميع المستخدمين}
                          {--confirm : تأكيد العملية}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'تبديل جميع كلمات المرور لكافة أنواع المستخدمين';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $password = $this->option('password');
        $confirm = $this->option('confirm');

        // طلب تأكيد إذا لم يتم تمرير --confirm
        if (!$confirm) {
            if (!$this->confirm("هل أنت متأكد من تغيير جميع كلمات المرور إلى '{$password}'؟")) {
                $this->info('تم إلغاء العملية.');
                return;
            }
        }

        $this->info("بدء تغيير جميع كلمات المرور إلى: {$password}");
        $this->line('===========================================');

        $totalUpdated = 0;

        // تحديث كلمات مرور المستخدمين (الإداريين)
        $usersUpdated = $this->updateUserPasswords($password);
        $totalUpdated += $usersUpdated;

        // تحديث كلمات مرور المعلمين
        $teachersUpdated = $this->updateTeacherPasswords($password);
        $totalUpdated += $teachersUpdated;

        // تحديث كلمات مرور الطلاب
        $studentsUpdated = $this->updateStudentPasswords($password);
        $totalUpdated += $studentsUpdated;

        // تحديث كلمات مرور الآباء
        $parentsUpdated = $this->updateParentPasswords($password);
        $totalUpdated += $parentsUpdated;

        $this->line('===========================================');
        $this->info("تم تحديث {$totalUpdated} كلمة مرور بنجاح!");
        $this->warn('تأكد من إبلاغ المستخدمين بكلمة المرور الجديدة: ' . $password);
    }

    private function updateUserPasswords($password)
    {
        $users = User::all();
        $updated = 0;

        foreach ($users as $user) {
            $user->password = Hash::make($password);
            $user->save();
            $updated++;
        }

        $this->line("✅ تم تحديث {$updated} كلمة مرور للمستخدمين (الإداريين)");
        return $updated;
    }

    private function updateTeacherPasswords($password)
    {
        $teachers = Teacher::all();
        $updated = 0;

        foreach ($teachers as $teacher) {
            $teacher->password = Hash::make($password);
            $teacher->save();
            $updated++;
        }

        $this->line("✅ تم تحديث {$updated} كلمة مرور للمعلمين");
        return $updated;
    }

    private function updateStudentPasswords($password)
    {
        $students = StudentAcount::all();
        $updated = 0;

        foreach ($students as $student) {
            $student->password = Hash::make($password);
            $student->save();
            $updated++;
        }

        $this->line("✅ تم تحديث {$updated} كلمة مرور للطلاب");
        return $updated;
    }

    private function updateParentPasswords($password)
    {
        $parents = MyParent::all();
        $updated = 0;

        foreach ($parents as $parent) {
            $parent->password = Hash::make($password);
            $parent->save();
            $updated++;
        }

        $this->line("✅ تم تحديث {$updated} كلمة مرور لأولياء الأمور");
        return $updated;
    }
}
