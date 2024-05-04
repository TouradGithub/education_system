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
        // $permissions = [
        //     ['id' => 1, 'name' => 'role-list'],
        //     ['id' => 2, 'name' => 'role-create'],
        //     ['id' => 3, 'name' => 'role-edit'],
        //     ['id' => 4, 'name' => 'role-delete'],

        //     ['id' => 5, 'name' => 'school-list'],
        //     ['id' => 6, 'name' => 'school-create'],
        //     ['id' => 7, 'name' => 'school-edit'],
        //     ['id' => 8, 'name' => 'school-delete'],

        //     ['id' => 9, 'name' => 'management-list'],
        //     ['id' => 10, 'name'=> 'management-create'],
        //     ['id' => 11, 'name'=> 'management-edit'],
        //     ['id' => 12, 'name'=> 'management-delete'],

        //     ['id' => 33, 'name'=> 'session-year-list'],
        //     ['id' => 34, 'name'=> 'session-year-create'],
        //     ['id' => 35, 'name'=> 'session-year-edit'],
        //     ['id' => 36, 'name'=> 'session-year-delete'],
        //     ['id' => 79, 'name' => 'setting-create'],


        //     ['name' => 'school-subject-create','type'=>'2'],
        //     [ 'name' => 'school-subject-index','type'=>'2'],
        //     [ 'name' => 'school-subject-store','type'=>'2'],
        //     [ 'name' => 'school-subject-edit','type'=>'2'],

        //     ['name' => 'school-sections-create','type'=>'2'],
        //     [ 'name' => 'school-sections-index','type'=>'2'],
        //     [ 'name' => 'school-sections-store','type'=>'2'],
        //     [ 'name' => 'school-sections-edit','type'=>'2'],

        //     ['name' => 'school-timetable-create','type'=>'2'],
        //     [ 'name' => 'school-timetable-index','type'=>'2'],
        //     [ 'name' => 'school-timetable-store','type'=>'2'],
        //     [ 'name' => 'school-timetable-edit','type'=>'2'],
        //     [ 'name' => 'school-class-timetable','type'=>'2'],

        //     ['name' => 'school-fees-create','type'=>'2'],
        //     [ 'name' => 'school-fees-index','type'=>'2'],
        //     [ 'name' => 'school-fees-store','type'=>'2'],
        //     [ 'name' => 'school-fees-paid','type'=>'2'],

        //     ['name' => 'school-attendance-create','type'=>'2'],
        //     [ 'name' => 'school-attendance-index','type'=>'2'],
        //     [ 'name' => 'school-attendance-store','type'=>'2'],
        //     [ 'name' => 'school-attendance-edit','type'=>'2'],

        //     ['name' => 'school-teachers-create','type'=>'2'],
        //     [ 'name' => 'school-teachers-index','type'=>'2'],
        //     [ 'name' => 'school-teachers-store','type'=>'2'],
        //     [ 'name' => 'school-subject-teachers','type'=>'2'],

        //     ['name' => 'school-students-create','type'=>'2'],
        //     [ 'name' => 'school-students-index','type'=>'2'],
        //     [ 'name' => 'school-students-store','type'=>'2'],
        //     [ 'name' => 'school-students-edit','type'=>'2'],
        //     [ 'name' => 'school-students-update','type'=>'2'],

        //     ['name' => 'school-students-create','type'=>'2'],
        //     [ 'name' => 'school-students-index','type'=>'2'],
        //     [ 'name' => 'school-students-store','type'=>'2'],
        //     [ 'name' => 'school-students-edit','type'=>'2'],
        //     [ 'name' => 'school-students-update','type'=>'2'],

        //     ['name' => 'school-tests-create','type'=>'2'],
        //     [ 'name' => 'school-tests-index','type'=>'2'],
        //     [ 'name' => 'school-tests-store','type'=>'2'],
        //     [ 'name' => 'school-tests-edit','type'=>'2'],
        //     [ 'name' => 'school-tests-update','type'=>'2'],


        //     ['name' => 'school-exams-create','type'=>'2'],
        //     [ 'name' => 'school-exams-index','type'=>'2'],
        //     [ 'name' => 'school-exams-store','type'=>'2'],
        //     [ 'name' => 'school-exams-edit','type'=>'2'],
        //     [ 'name' => 'school-exams-update','type'=>'2'],

        //     [ 'name' => 'school-settings-create','type'=>'2'],

        //     [ 'name' => 'school-general_settings-create','type'=>'2'],
        //     [ 'name' => 'school-general_settings-update','type'=>'2'],


        //     ['name' => 'school-user-create','type'=>'2'],
        //     [ 'name' => 'school-user-index','type'=>'2'],
        //     [ 'name' => 'school-user-store','type'=>'2'],
        //     [ 'name' => 'school-user-edit','type'=>'2'],
        //     [ 'name' => 'school-user-update','type'=>'2'],


        //     ['name' => 'school-role-create','type'=>'2'],
        //     [ 'name' => 'school-role-index','type'=>'2'],
        //     [ 'name' => 'school-role-store','type'=>'2'],
        //     [ 'name' => 'school-role-edit','type'=>'2'],
        //     [ 'name' => 'school-role-update','type'=>'2'],



        // ];
        // foreach ($permissions as $permission) {
        //     Permission::updateOrCreate(['id' => $permission['id']], $permission);
        // }


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
