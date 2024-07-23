<?php

namespace App\Services\Employee;

use App\Exceptions\DataNotFoundException;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class ReadEmployeeService
{
    public function findAll()
    {
        $employees = DB::table('employee')->where('deleted_at', '=', NULL)->get();

        if (!$employees) {
            throw new DataNotFoundException('Employee data not found');
        }

        return $employees;
    }

    public function findEmployeeByEmail($email): ?Object
    {
        $employee = DB::table('employee')
            ->where('email', $email)
            ->first();

        return $employee;
    }
}
