<?php

namespace App\Services\Role;

use App\Exceptions\DataNotFoundException;
use Illuminate\Support\Facades\DB;

class ReadRoleService
{
    public function findAll()
    {
        $roles = DB::table('roles as r')
            ->join('role_has_permissions as rp', 'rp.role_id', '=', 'r.id')
            ->join('permissions as p', 'rp.permission_id', '=', 'p.id')
            ->select('r.name as role_name', 'p.name as permission')
            ->get();

        $roles = $roles->groupBy('role_name')
            ->map(function ($items, $key) {
                return [
                    'role_name' => $items[0]->role_name,
                    'permissions' => $items->pluck('permission')->toArray()
                ];
            })->values()->toArray();

        if (!$roles) {
            throw new DataNotFoundException('Roles data not found');
        }

        return $roles;
    }
}
