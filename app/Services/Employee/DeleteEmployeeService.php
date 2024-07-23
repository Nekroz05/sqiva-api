<?php

namespace App\Services\Employee;

use App\Exceptions\DataNotFoundException;
use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class DeleteEmployeeService
{
    public function deleteEmployee($id)
    {
        try {
            DB::beginTransaction();
            $employee = DB::table('employee')->where('id', $id);

            if (!$employee->first()) {
                throw new DataNotFoundException('Employee data not found');
            }

            $employee->update([
                'deleted_at' => date('Y-m-d H:i:s')
            ]);
        } catch (\Exception $err) {
            DB::rollback();
            throw $err;
        }

        DB::commit();
        return $employee->first();
    }
}
