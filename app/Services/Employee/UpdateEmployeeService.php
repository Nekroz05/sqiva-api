<?php

namespace App\Services\Employee;

use App\Exceptions\DataNotFoundException;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class UpdateEmployeeService
{
    public function updateEmployee($id, $firstName, $lastName, $email, $password, $age, $weight)
    {
        try {
            DB::beginTransaction();

            $employee = DB::table('employee')->where('id', '=', $id);

            if (!$employee->first()) {
                throw new DataNotFoundException('Employee data not found');
            }

            $employee->update([
                'team_id' => 1,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'password' => $password,
                'age' => $age,
                'weight' => $weight
            ]);
        } catch (\Exception $err) {
            DB::rollback();
            throw $err;
        }

        DB::commit();

        return $employee->first();
    }
}
