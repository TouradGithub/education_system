<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ResetAdminPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:reset-password
                          {email : البريد الإلكتروني للمدير}
                          {password : كلمة المرور الجديدة}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'إعادة تعيين كلمة مرور المدير';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("لم يتم العثور على مستخدم بالبريد الإلكتروني: {$email}");
            return;
        }

        $user->password = Hash::make($password);
        $user->save();

        $this->info("تم تحديث كلمة مرور المستخدم {$user->name} ({$email}) بنجاح!");
        $this->line("كلمة المرور الجديدة: {$password}");
    }
}
