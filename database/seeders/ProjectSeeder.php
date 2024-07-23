<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('project')->insert([
            [
                'name' => 'Work Management System',
                'create_by' => 1
            ],
            [
                'name' => 'HRIS',
                'create_by' => 1
            ],
            [
                'name' => 'Accounting System',
                'create_by' => 1
            ],
            [
                'name' => 'Attendance System',
                'create_by' => 1
            ],
        ]);
    }
}
