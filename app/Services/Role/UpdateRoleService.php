<?php

namespace App\Services\Role;

use App\Exceptions\DataNotFoundException;
use App\Exceptions\DuplicateDataException;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UpdateRoleService
{
    public function updateRole($id, $name, $permissions)
    {
        try
        {
            DB::beginTransaction();

            $role = DB::table('roles');

            $role->where('id', '=', $id);

            if (!$role->first())
            {
                throw new DataNotFoundException('Role does not exist');
            }

            $duplicateRole = DB::table('roles')->where([
                ['name', '=', $name],
                ['id', '!=', $id],
            ])->first();

            if ($duplicateRole)
            {
                throw new DuplicateDataException('Role name must be unique');
            }

            $role->update([
                'name' => $name,
                'guard_name' => 'web'
            ]);

            $updatedRole = Role::find($id);

            $updatedRole->syncPermissions($permissions);

            // foreach ($permissions as $key => $value) {
            //     $permission = Permission::find($value);
            //     $updatedRole->givePermissionTo($permission);
            // }
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
