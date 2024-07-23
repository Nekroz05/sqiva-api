<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employee-project')->insert([
            [
                'employee_id' => 1,
                'project_id' => 1,
                'create_by' => 1
            ],
            [
                'employee_id' => 1,
                'project_id' => 2,
                'create_by' => 1
            ],
            [
                'employee_id' => 1,
                'project_id' => 3,
                'create_by' => 1
            ],
            [
                'employee_id' => 2,
                'project_id' => 1,
                'create_by' => 1
            ],
            [
                'employee_id' => 2,
                'project_id' => 3,
                'create_by' => 1
            ],
        ]);
    }
}
