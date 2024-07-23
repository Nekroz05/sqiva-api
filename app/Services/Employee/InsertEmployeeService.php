<?php

namespace App\Services\Employee;

use App\Exceptions\DuplicateDataException;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class InsertEmployeeService
{
    public function addEmployee($firstName, $lastName, $email, $password, $age, $weight)
    {
        try {
            DB::beginTransaction();

            $employee = DB::table('employee')
                ->where('email', '=', $email)->first();

            if ($employee) {
                throw new DuplicateDataException('Employee email must be unique');
            }

            $employee = new Employee;
            $employee->team_id = 1;
            $employee->first_name = $firstName;
            $employee->last_name = $lastName;
            $employee->email = $email;
            $employee->password = $password;
            $employee->age = $age;
            $employee->weight = $weight;
            $employee->create_by = 1;
            $employee->save();
        } catch (\Exception $err) {
            DB::rollback();
            throw $err;
        }

        DB::commit();
        return $employee;
    }
}
