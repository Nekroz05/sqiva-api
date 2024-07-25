<?php

namespace App\Services\Role;

use App\Exceptions\DuplicateDataException;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class InsertRoleService
{
    public function addRole($name, $permissions)
    {
        try
        {
            DB::beginTransaction();

            $role = DB::table('roles');

            $duplicateRole = $role->where('name', '=', $name)->first();

            if ($duplicateRole)
            {
                throw new DuplicateDataException('Role name must be unique');
            }

            $role->insert([
                'name' => $name,
                'guard_name' => 'web'
            ]);

            $createdRole = Role::where('name', '=', $name)->first();

            foreach ($permissions as $key => $value)
            {
                $permission = Permission::find($value);
                $createdRole->givePermissionTo($permission);
            }
        }
        catch (\Exception $err)
        {
            DB::rollback();
            throw $err;
        }

        DB::commit();
        return $role->first();
    }
}
