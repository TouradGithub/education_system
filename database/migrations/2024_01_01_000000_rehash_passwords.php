<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $newPassword = '12345678';

        // تحديث كلمات المرور للمستخدمين إلى 12345678
        DB::table('users')->update([
            'password' => Hash::make($newPassword)
        ]);

        // تحديث كلمات المرور للمعلمين إلى 12345678
        DB::table('teachers')->update([
            'password' => Hash::make($newPassword)
        ]);

        // تحديث كلمات المرور لحسابات الطلاب إلى 12345678
        DB::table('student_acount')->update([
            'password' => Hash::make($newPassword)
        ]);

        // تحديث كلمات المرور للآباء إلى 12345678
        DB::table('my_parents')->update([
            'password' => Hash::make($newPassword)
        ]);

        // طباعة رسالة في الـ logs
        \Log::info('تم تحديث جميع كلمات المرور إلى: ' . $newPassword);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // لا يمكن العكس - كلمات المرور الأصلية ستُفقد
    }
};
