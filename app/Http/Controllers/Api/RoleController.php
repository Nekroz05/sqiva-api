<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\DataNotFoundException;
use App\Exceptions\DuplicateDataException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\AssignRoleRequest;
use App\Http\Requests\Role\DeleteRoleRequest;
use App\Http\Requests\Role\InsertRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use App\Services\Role\AssignRoleService;
use App\Services\Role\DeleteRoleService;
use App\Services\Role\InsertRoleService;
use App\Services\Role\ReadRoleService;
use App\Services\Role\UpdateRoleService;

class RoleController extends Controller
{
    public function findAll(ReadRoleService $roleService)
    {
        try {
            $roles = $roleService->findAll();

            return new RoleResource(
                $roles,
                'Data found',
                200
            );
        } catch (DataNotFoundException $err) {
            return response()->json([
                'error' => $err->getMessage()
            ], 400);
        } catch (\Exception $err) {
            return response()->json([
                'error' => $err->getMessage()
            ], 400);
        }
    }

    public function insert(InsertRoleRequest $request, InsertRoleService $roleService)
    {
        try {
            $role = $roleService->addRole(
                $request->name,
                $request->permissions
            );

            return new RoleResource(
                $role,
                'Role data created',
                200
            );
        } catch (DuplicateDataException $err) {
            return response()->json([
                'error' => $err->getMessage()
            ], 400);
        } catch (\Exception $err) {
            return response()->json([
                'error' => $err->getMessage()
            ], 400);
        }
    }

    public function update($id, UpdateRoleRequest $request, UpdateRoleService $roleService)
    {
        try {
            $role = $roleService->updateRole($id, $request->name, $request->permissions);

            return new RoleResource(
                $role,
                'Role data updated',
                200
            );
        } catch (DataNotFoundException $err) {
            return response()->json([
                'error' => $err->getMessage()
            ], 400);
        } catch (DuplicateDataException $err) {
            return response()->json([
                'error' => $err->getMessage()
            ], 400);
        } catch (\Exception $err) {
            return response()->json([
                'error' => $err->getMessage()
            ], 400);
        }
    }

    public function delete(DeleteRoleRequest $request, DeleteRoleService $roleService)
    {
        try {
            $role = $roleService->deleteRole($request->id);

            return new RoleResource(
                $role,
                'Role data deleted',
                200
            );
        } catch (DataNotFoundException $err) {
            return response()->json([
                'error' => $err->getMessage()
            ], 400);
        } catch (\Exception $err) {
            return response()->json([
                'error' => $err->getMessage()
            ], 400);
        }
    }

    public function assignToEmployee(AssignRoleRequest $request, AssignRoleService $roleService)
    {
        try {
            $role = $roleService->assignRoleToEmployee(
                $request->employee_id,
                $request->roles
            );

            return new RoleResource(
                $role,
                'Role assigned',
                200
            );
        } catch (\Exception $err) {
            return response()->json([
                'error' => $err->getMessage()
            ], 400);
        }
    }
}
