<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
class SchoolSuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
    ['id' => 100, 'name' => 'school-subject-create', 'type' => '2'],
    ['id' => 101, 'name' => 'school-subject-index', 'type' => '2'],
    ['id' => 102, 'name' => 'school-subject-store', 'type' => '2'],
    ['id' => 103, 'name' => 'school-subject-edit', 'type' => '2'],

    ['id' => 104, 'name' => 'school-sections-create', 'type' => '2'],
    ['id' => 105, 'name' => 'school-sections-index', 'type' => '2'],
    ['id' => 106, 'name' => 'school-sections-store', 'type' => '2'],
    ['id' => 107, 'name' => 'school-sections-edit', 'type' => '2'],

    ['id' => 108, 'name' => 'school-timetable-create', 'type' => '2'],
    ['id' => 109, 'name' => 'school-timetable-index', 'type' => '2'],
    ['id' => 110, 'name' => 'school-timetable-store', 'type' => '2'],
    ['id' => 111, 'name' => 'school-timetable-edit', 'type' => '2'],
    ['id' => 112, 'name' => 'school-class-timetable', 'type' => '2'],

    ['id' => 113, 'name' => 'school-fees-create', 'type' => '2'],
    ['id' => 114, 'name' => 'school-fees-class-index', 'type' => '2'],
    ['id' => 115, 'name' => 'school-fees-store', 'type' => '2'],
    ['id' => 116, 'name' => 'school-fees-paid-index', 'type' => '2'],

    ['id' => 117, 'name' => 'school-attendance-create', 'type' => '2'],
    ['id' => 118, 'name' => 'school-attendance-index', 'type' => '2'],
    ['id' => 119, 'name' => 'school-attendance-store', 'type' => '2'],
    ['id' => 120, 'name' => 'school-attendance-edit', 'type' => '2'],

    ['id' => 121, 'name' => 'school-teachers-create', 'type' => '2'],
    ['id' => 122, 'name' => 'school-teachers-index', 'type' => '2'],
    ['id' => 123, 'name' => 'school-teachers-store', 'type' => '2'],
    ['id' => 124, 'name' => 'school-subject-teachers', 'type' => '2'],
    ['id' => 124, 'name' => 'school-subject-teacher-list', 'type' => '2'],
    ['id' => 124, 'name' => 'school-subject-teacher-edit', 'type' => '2'],
    ['id' => 124, 'name' => 'school-subject-teacher-create', 'type' => '2'],
    ['id' => 124, 'name' => 'school-subject-teacher-delete', 'type' => '2'],

    ['id' => 125, 'name' => 'school-students-create', 'type' => '2'],
    ['id' => 126, 'name' => 'school-students-index', 'type' => '2'],
    ['id' => 127, 'name' => 'school-students-store', 'type' => '2'],
    ['id' => 128, 'name' => 'school-students-edit', 'type' => '2'],
    ['id' => 129, 'name' => 'school-students-update', 'type' => '2'],

    ['id' => 130, 'name' => 'school-tests-create', 'type' => '2'],
    ['id' => 131, 'name' => 'school-tests-index', 'type' => '2'],
    ['id' => 132, 'name' => 'school-tests-store', 'type' => '2'],
    ['id' => 133, 'name' => 'school-tests-edit', 'type' => '2'],
    ['id' => 134, 'name' => 'school-tests-update', 'type' => '2'],

    ['id' => 135, 'name' => 'school-exams-create', 'type' => '2'],
    ['id' => 136, 'name' => 'school-exams-index', 'type' => '2'],
    ['id' => 137, 'name' => 'school-exams-store', 'type' => '2'],
    ['id' => 138, 'name' => 'school-exams-edit', 'type' => '2'],
    ['id' => 139, 'name' => 'school-exams-update', 'type' => '2'],

    ['id' => 140, 'name' => 'school-settings-create', 'type' => '2'],

    ['id' => 141, 'name' => 'school-general_settings-create', 'type' => '2'],
    ['id' => 142, 'name' => 'school-general_settings-update', 'type' => '2'],

    ['id' => 143, 'name' => 'school-user-create', 'type' => '2'],
    ['id' => 144, 'name' => 'school-user-index', 'type' => '2'],
    ['id' => 145, 'name' => 'school-user-store', 'type' => '2'],
    ['id' => 146, 'name' => 'school-user-edit', 'type' => '2'],
    ['id' => 147, 'name' => 'school-user-update', 'type' => '2'],

    ['id' => 148, 'name' => 'school-role-create', 'type' => '2'],
    ['id' => 149, 'name' => 'school-role-index', 'type' => '2'],
    ['id' => 150, 'name' => 'school-role-store', 'type' => '2'],
    ['id' => 151, 'name' => 'school-role-edit', 'type' => '2'],
    ['id' => 152, 'name' => 'school-role-update', 'type' => '2'],


        ];
        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['id' => $permission['id']], $permission);
        }

        $role = Role::updateOrCreate(['name' => 'Admin School']);
        $permissions_list  = [
                'school-subject-create',
                'school-subject-index',
                'school-subject-store',
                'school-subject-edit',

                'school-sections-create',
                'school-sections-index',
                'school-sections-store',
                'school-sections-edit',

                'school-timetable-create',
                'school-timetable-index',
                'school-timetable-store',
                'school-timetable-edit',
                'school-class-timetable',

                'school-fees-create',
                'school-fees-index',
                'school-fees-store',
                'school-fees-paid',

                'school-attendance-create',
                'school-attendance-index',
                'school-attendance-store',
                'school-attendance-edit',

                'school-teachers-create',
                'school-teachers-index',
                'school-teachers-store',
                'school-subject-teachers',

                'school-students-create',
                'school-students-index',
                'school-students-store',
                'school-students-edit',
                'school-students-update',

                'school-students-create',
                'school-students-index',
                'school-students-store',
                'school-students-edit',
                'school-students-update',

                'school-tests-create',
                'school-tests-index',
                'school-tests-store',
                'school-tests-edit',
                'school-tests-update',

                'school-exams-create',
                'school-exams-index',
                'school-exams-store',
                'school-exams-edit',
                'school-exams-update',

                'school-settings-create',

                'school-general_settings-create',
                'school-general_settings-update',

                'school-user-create',
                'school-user-index',
                'school-user-store',
                'school-user-edit',
                'school-user-update',

                'school-role-create',
                'school-role-index',
                'school-role-store',
                'school-role-edit',
                'school-role-update',
        ];
        $role->syncPermissions($permissions_list);
    }
}
