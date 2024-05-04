<?php

namespace Database\Seeders;

use App\Models\SessionYear;
use App\Models\Settings;
use App\Models\User;
use App\Models\Grade;
use App\Models\Section;
use App\Models\Classes;
use App\Models\Teacher;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Generator as Faker;
use App\Models\ClassRoom;
class AddSuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        //Add Super Admin User
        $super_admin_role = Role::where('name', 'Admin')->first();
        $user = User::updateOrCreate(['id' => 1], [
            'name' => 'super',
            'email' => 'superadmin@gmail.com',
            'phone' => '85739488',
            'model' => 'App\Models\Admin',
            'model_id' => '1',
            'password' => Hash::make('superadmin'),
            'role'=>$super_admin_role->name,
        ]);
        $user->assignRole([$super_admin_role->id]);

        // Grade::factory(10)->create();
        // Classes::factory(10)->create();
        // Teacher::factory(10)->create();
        ClassRoom::create([
            "name" => ['en' => "Test en", 'ar' =>"sdlfjsldkj"],
            "grade_id" => "1",
            "class_id" => "1",
            "school_id" => "1",
            "notes" => "slkjdlfk note",
        ]);



    }
}
