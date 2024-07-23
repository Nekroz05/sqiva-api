<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\DataNotFoundException;
use App\Exceptions\DuplicateDataException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\DeleteEmployeeRequest;
use App\Http\Requests\Employee\InsertEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Services\Employee\DeleteEmployeeService;
use App\Services\Employee\InsertEmployeeService;
use App\Services\Employee\ReadEmployeeService;
use App\Services\Employee\UpdateEmployeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index(ReadEmployeeService $readEmployeeService)
    {
        try {
            $employees = $readEmployeeService->findAll();

            return new EmployeeResource(
                $employees,
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

    public function insert(InsertEmployeeRequest $request, InsertEmployeeService $insertEmployeeService)
    {
        try {
            $newEmployee = $insertEmployeeService->addEmployee(
                $request->first_name,
                $request->last_name,
                $request->email,
                Hash::make($request->password),
                $request->age,
                $request->weight
            );

            unset($newEmployee->password);

            return new EmployeeResource(
                $newEmployee,
                'Employee data created',
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

    public function update($id, UpdateEmployeeRequest $request, UpdateEmployeeService $updateEmployeeService)
    {
        try {
            $updatedEmployee = $updateEmployeeService->updateEmployee(
                $id,
                $request->first_name,
                $request->last_name,
                $request->email,
                Hash::make($request->password),
                $request->age,
                $request->weight
            );

            // unset($updatedEmployee->password);

            return new EmployeeResource(
                $updatedEmployee,
                'Employee data updated',
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

    public function delete(DeleteEmployeeRequest $request, DeleteEmployeeService $deleteEmployeeService)
    {
        try {
            $deletedEmployee = $deleteEmployeeService->deleteEmployee($request->id);

            return new EmployeeResource(
                $deletedEmployee,
                'Employee data deleted',
                200
            );
        } catch (DataNotFoundException $err) {
            return response()->json([
                'error' => $err->getMessage()
            ], 400);
        } catch (\Throwable $err) {
            return response()->json([
                'error' => $err->getMessage()
            ], 400);
        }
    }
}
