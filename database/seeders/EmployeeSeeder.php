<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employee')->insert([
            [
                'team_id' => 1,
                'first_name' => 'Indra',
                'last_name' => 'Oei',
                'email' => 'indraoei25@gmail.com',
                'password' => Hash::make('asdasd'),
                'age' => 25,
                'weight' => '60 kg',
                'create_by' => 1
            ],
            [
                'team_id' => 1,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'johndoe@example.com',
                'password' => Hash::make('asdasd'),
                'age' => 30,
                'weight' => '70 kg',
                'create_by' => 1
            ],
        ]);
    }
}
