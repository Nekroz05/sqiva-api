<?php

namespace App\Services\Role;

use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class AssignRoleService
{
    public function assignRoleToEmployee($employee_id, $roles)
    {
        try {
            DB::beginTransaction();

            $employee = Employee::find($employee_id);

            foreach ($roles as $key => $role) {
                $role = DB::table('roles')->where('name', '=', $role)->first();
                $employee->assignRole($role->name);
            }
        } catch (\Exception $err) {
            DB::rollback();
            throw $err;
        }

        DB::commit();
        return $employee;
    }
}
