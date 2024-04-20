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
            ['id' => 4, 'name' => 'role-delete'],

            ['id' => 5, 'name' => 'school-list'],
            ['id' => 6, 'name' => 'school-create'],
            ['id' => 7, 'name' => 'school-edit'],
            ['id' => 8, 'name' => 'school-delete'],

            ['id' => 9, 'name' => 'management-list'],
            ['id' => 10, 'name'=> 'management-create'],
            ['id' => 11, 'name'=> 'management-edit'],
            ['id' => 12, 'name'=> 'management-delete'],

            ['id' => 33, 'name'=> 'session-year-list'],
            ['id' => 34, 'name'=> 'session-year-create'],
            ['id' => 35, 'name'=> 'session-year-edit'],
            ['id' => 36, 'name'=> 'session-year-delete'],
            ['id' => 79, 'name' => 'setting-create'],

        ];
        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['id' => $permission['id']], $permission);
        }


        $role = Role::updateOrCreate(['name' => 'Admin']);
        $superadmin_permission_list = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',

            'school-list',
            'school-create',
            'school-edit',
            'school-delete',

            'management-list',
            'management-create',
            'management-edit',
            'management-delete',

            'session-year-list',
            'session-year-create',
            'session-year-edit',
            'session-year-delete',
            'setting-create',

        ];
        $role->syncPermissions($superadmin_permission_list);

 ;



        //Change system version here

        //clear cache
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
    }
}
