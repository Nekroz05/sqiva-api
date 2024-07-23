<?php

namespace Tests;

use App\Models\Employee;
use Database\Seeders\EmployeeSeeder;
use Database\Seeders\RoleAndPermissionSeeder;
use Database\Seeders\TeamSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use DatabaseMigrations;

    public function sanctumLogin($id)
    {
        $this->seed(TeamSeeder::class);
        $this->seed(EmployeeSeeder::class);
        $this->seed(RoleAndPermissionSeeder::class);

        $user = Employee::find($id);
        $this->actingAs($user);

        return $user->createToken('test-token')->plainTextToken;
    }
}
