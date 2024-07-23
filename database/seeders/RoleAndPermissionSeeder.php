<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'SuperAdmin',
            'guard_name' => 'web'
        ]);

        Permission::create([
            'name' => 'employee.create',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'employee.read',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'employee.update',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'employee.delete',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'role.create',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'role.read',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'role.update',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'role.delete',
            'guard_name' => 'web'
        ]);
        Permission::create([
            'name' => 'role.assign',
            'guard_name' => 'web'
        ]);

        $superAdmin = Role::find(1);
        $superAdmin->givePermissionTo(Permission::all());

        $employee = Employee::find(1);
        $employee->assignRole($superAdmin);
    }
}
