<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Teacher;
use App\Models\StudentAcount;
use App\Models\MyParent;

class CheckPasswordHashing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'password:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'فحص كلمات المرور للتأكد من أنها مشفرة بـ bcrypt';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->checkUsers();
        $this->checkTeachers();
        $this->checkStudents();
        $this->checkParents();
    }

    private function checkUsers()
    {
        $users = User::all();
        $unhashed = 0;

        foreach ($users as $user) {
            if (Hash::needsRehash($user->password)) {
                $unhashed++;
                $this->warn("المستخدم ID {$user->id} ({$user->email}) كلمة المرور غير مشفرة بـ bcrypt");
            }
        }

        if ($unhashed === 0) {
            $this->info("جميع كلمات مرور المستخدمين ({$users->count()}) مشفرة بشكل صحيح");
        } else {
            $this->error("يوجد {$unhashed} مستخدم بكلمات مرور غير مشفرة من أصل {$users->count()}");
        }
    }

    private function checkTeachers()
    {
        $teachers = Teacher::whereNotNull('password')->get();
        $unhashed = 0;

        foreach ($teachers as $teacher) {
            if (Hash::needsRehash($teacher->password)) {
                $unhashed++;
                $this->warn("المعلم ID {$teacher->id} ({$teacher->email}) كلمة المرور غير مشفرة بـ bcrypt");
            }
        }

        if ($unhashed === 0) {
            $this->info("جميع كلمات مرور المعلمين ({$teachers->count()}) مشفرة بشكل صحيح");
        } else {
            $this->error("يوجد {$unhashed} معلم بكلمات مرور غير مشفرة من أصل {$teachers->count()}");
        }
    }

    private function checkStudents()
    {
        $students = StudentAcount::whereNotNull('password')->get();
        $unhashed = 0;

        foreach ($students as $student) {
            if (Hash::needsRehash($student->password)) {
                $unhashed++;
                $this->warn("الطالب ID {$student->id} كلمة المرور غير مشفرة بـ bcrypt");
            }
        }

        if ($unhashed === 0) {
            $this->info("جميع كلمات مرور الطلاب ({$students->count()}) مشفرة بشكل صحيح");
        } else {
            $this->error("يوجد {$unhashed} طالب بكلمات مرور غير مشفرة من أصل {$students->count()}");
        }
    }

    private function checkParents()
    {
        $parents = MyParent::whereNotNull('password')->get();
        $unhashed = 0;

        foreach ($parents as $parent) {
            if (Hash::needsRehash($parent->password)) {
                $unhashed++;
                $this->warn("الولي ID {$parent->id} كلمة المرور غير مشفرة بـ bcrypt");
            }
        }

        if ($unhashed === 0) {
            $this->info("جميع كلمات مرور الآباء ({$parents->count()}) مشفرة بشكل صحيح");
        } else {
            $this->error("يوجد {$unhashed} ولي أمر بكلمات مرور غير مشفرة من أصل {$parents->count()}");
        }
    }
}
