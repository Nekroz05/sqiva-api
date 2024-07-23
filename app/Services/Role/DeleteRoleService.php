<?php

namespace App\Services\Role;

use App\Exceptions\DataNotFoundException;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class DeleteRoleService
{
    public function deleteRole($id)
    {
        try {
            DB::beginTransaction();

            $role = DB::table('roles')->where('id', '=', $id);

            if (!$role->first()) {
                throw new DataNotFoundException('Role does not exist');
            }

            // revoke all permission;
            $deletedRole = Role::find($id);
            $deletedRole->syncPermissions();

            $role->delete();
        } catch (\Exception $err) {
            DB::rollback();
            throw $err;
        }

        DB::commit();
        return $role->first();
    }
}
