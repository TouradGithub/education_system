<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Teacher;
use App\Models\StudentAcount;
use App\Models\MyParent;

class RehashPasswords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'password:rehash
                          {--model= : النموذج المحدد لإعادة التشفير (users, teachers, students, parents)}
                          {--default-password= : كلمة مرور افتراضية إذا كانت غير مشفرة}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'إعادة تشفير كلمات المرور باستخدام bcrypt';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $model = $this->option('model');
        $defaultPassword = $this->option('default-password') ?? '123456';

        if (!$model || $model === 'users') {
            $this->rehashUserPasswords($defaultPassword);
        }

        if (!$model || $model === 'teachers') {
            $this->rehashTeacherPasswords($defaultPassword);
        }

        if (!$model || $model === 'students') {
            $this->rehashStudentPasswords($defaultPassword);
        }

        if (!$model || $model === 'parents') {
            $this->rehashParentPasswords($defaultPassword);
        }

        $this->info('تم إعادة تشفير كلمات المرور بنجاح!');
    }

    private function rehashUserPasswords($defaultPassword)
    {
        $users = User::all();
        $count = 0;

        foreach ($users as $user) {
            if (!Hash::needsRehash($user->password)) {
                continue; // كلمة المرور مشفرة بالفعل
            }

            // استخدام كلمة المرور الافتراضية إذا كانت غير مشفرة
            $user->password = Hash::make($defaultPassword);
            $user->save();
            $count++;
        }

        $this->line("تم إعادة تشفير {$count} كلمة مرور للمستخدمين");
    }

    private function rehashTeacherPasswords($defaultPassword)
    {
        $teachers = Teacher::all();
        $count = 0;

        foreach ($teachers as $teacher) {
            if (!$teacher->password || !Hash::needsRehash($teacher->password)) {
                continue;
            }

            $teacher->password = Hash::make($defaultPassword);
            $teacher->save();
            $count++;
        }

        $this->line("تم إعادة تشفير {$count} كلمة مرور للمعلمين");
    }

    private function rehashStudentPasswords($defaultPassword)
    {
        $students = StudentAcount::all();
        $count = 0;

        foreach ($students as $student) {
            if (!$student->password || !Hash::needsRehash($student->password)) {
                continue;
            }

            $student->password = Hash::make($defaultPassword);
            $student->save();
            $count++;
        }

        $this->line("تم إعادة تشفير {$count} كلمة مرور للطلاب");
    }

    private function rehashParentPasswords($defaultPassword)
    {
        $parents = MyParent::all();
        $count = 0;

        foreach ($parents as $parent) {
            if (!$parent->password || !Hash::needsRehash($parent->password)) {
                continue;
            }

            $parent->password = Hash::make($defaultPassword);
            $parent->save();
            $count++;
        }

        $this->line("تم إعادة تشفير {$count} كلمة مرور للآباء");
    }
}
