<?php

namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Settings;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;

class InstallationSeeder extends Seeder
{

    public function run() {

        //Add Permissions
        $permissions = [
            ['id' => 1, 'name' => 'role-list'],
            ['id' => 2, 'name' => 'role-create'],
            ['id' => 3, 'name' => 'role-edit'],
            ['id' => 45, 'name' => 'role-show'],
            ['id' => 4, 'name' => 'role-delete'],

            ['id' => 5, 'name' => 'school-list'],
            ['id' => 6, 'name' => 'school-create'],
            ['id' => 7, 'name' => 'school-edit'],
            ['id' => 46, 'name' => 'school-show'],
            ['id' => 8, 'name' => 'school-delete'],

            ['id' => 9, 'name' => 'acadimic-list'],
            ['id' => 10, 'name'=> 'acadimic-create'],
            ['id' => 11, 'name'=> 'acadimic-edit'],
            ['id' => 47, 'name'=> 'acadimic-show'],
            ['id' => 12, 'name'=> 'acadimic-delete'],

            ['id' => 13, 'name' => 'grade-list'],
            ['id' => 14, 'name'=> 'grade-create'],
            ['id' => 15, 'name'=> 'grade-edit'],
            ['id' => 16, 'name'=> 'grade-show'],
            ['id' => 17, 'name'=> 'grade-delete'],

            ['id' => 18, 'name' => 'classes-list'],
            ['id' => 19, 'name'=> 'classes-create'],
            ['id' => 20, 'name'=> 'classes-edit'],
            ['id' => 21, 'name'=> 'classes-show'],
            ['id' => 22, 'name'=> 'classes-delete'],

            ['id' => 23, 'name' => 'trimester-list'],
            ['id' => 24, 'name'=> 'trimester-create'],
            ['id' => 25, 'name'=> 'trimester-edit'],
            ['id' => 26, 'name'=> 'trimester-show'],
            ['id' => 27, 'name'=> 'trimester-delete'],

            ['id' => 28, 'name' => 'announcement-list'],
            ['id' => 29, 'name'=> 'announcement-create'],
            ['id' => 30, 'name'=> 'announcement-edit'],
            ['id' => 31, 'name'=> 'announcement-show'],
            ['id' => 32, 'name'=> 'announcement-delete'],

            ['id' => 33, 'name' => 'users-list'],
            ['id' => 34, 'name'=> 'users-create'],
            ['id' => 35, 'name'=> 'users-edit'],
            ['id' => 36, 'name'=> 'users-show'],
            ['id' => 37, 'name'=> 'users-delete'],

            ['id' => 38, 'name'=> 'statistic-gender'],
            ['id' => 39, 'name'=> 'statistic-counter'],

            ['id' => 40, 'name'=> 'session-year-list'],
            ['id' => 41, 'name'=> 'session-year-create'],
            ['id' => 42, 'name'=> 'session-year-show'],
            ['id' => 43, 'name'=> 'session-year-edit'],
            ['id' => 44, 'name'=> 'session-year-delete'],



            ['id' => 79, 'name' => 'setting-create'],





        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['id' => $permission['id']], $permission);
        }

        $role = Role::updateOrCreate(['name' => 'Admin']);
        $superadmin_permission_list = [

            'session-year-list',
            'session-year-create',
            'session-year-show',
            'session-year-edit',
            'session-year-delete',

            'role-list',
            'role-create',
            'role-edit',
            'role-show',
            'role-delete',

            'school-list',
            'school-create',
            'school-edit',
            'school-show',
            'school-delete',

            'acadimic-list',
            'acadimic-create',
            'acadimic-edit',
            'acadimic-show',
            'acadimic-delete',

            'grade-list',
            'grade-create',
            'grade-edit',
            'grade-show',
            'grade-delete',

            'classes-list',
            'classes-create',
            'classes-edit',
            'classes-show',
            'classes-delete',

            'trimester-list',
            'trimester-create',
            'trimester-edit',
            'trimester-show',
            'trimester-delete',

            'announcement-list',
            'announcement-create',
            'announcement-edit',
            'announcement-show',
            'announcement-delete',

            'users-list',
            'users-create',
            'users-edit',
            'users-show',
            'users-delete',

            'statistic-gender',
            'statistic-counter',

            'setting-create',
        ];
        $role->syncPermissions($superadmin_permission_list);

        //clear cache
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
    }
}
