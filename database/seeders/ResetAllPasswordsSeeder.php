<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Teacher;
use App\Models\StudentAcount;
use App\Models\MyParent;

class ResetAllPasswordsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $newPassword = '12345678';

        $this->command->info('بدء تحديث جميع كلمات المرور إلى: ' . $newPassword);

        // تحديث كلمات مرور المستخدمين (الإداريين)
        $usersCount = User::count();
        User::query()->update(['password' => Hash::make($newPassword)]);
        $this->command->line("✅ تم تحديث {$usersCount} كلمة مرور للمستخدمين");

        // تحديث كلمات مرور المعلمين
        $teachersCount = Teacher::count();
        Teacher::query()->update(['password' => Hash::make($newPassword)]);
        $this->command->line("✅ تم تحديث {$teachersCount} كلمة مرور للمعلمين");

        // تحديث كلمات مرور الطلاب
        $studentsCount = StudentAcount::count();
        StudentAcount::query()->update(['password' => Hash::make($newPassword)]);
        $this->command->line("✅ تم تحديث {$studentsCount} كلمة مرور للطلاب");

        // تحديث كلمات مرور أولياء الأمور
        $parentsCount = MyParent::count();
        MyParent::query()->update(['password' => Hash::make($newPassword)]);
        $this->command->line("✅ تم تحديث {$parentsCount} كلمة مرور لأولياء الأمور");

        $total = $usersCount + $teachersCount + $studentsCount + $parentsCount;
        $this->command->info("تم تحديث {$total} كلمة مرور إجمالاً!");
        $this->command->warn('كلمة المرور الجديدة لجميع المستخدمين: ' . $newPassword);
    }
}
