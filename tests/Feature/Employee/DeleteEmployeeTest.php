<?php

namespace Tests\Feature\Employee;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class DeleteEmployeeTest extends TestCase
{
    public function testDeleteEmployeeSuccess(): void
    {
        $param = [
            'id' => 2,
        ];

        $this->sanctumLogin(1);

        $this->assertAuthenticated();

        $response = $this->delete(config('api.host_name') . '/employee', $param, []);

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure(['code', 'message', 'data']);
    }

    public function testDeleteEmployeeFailed(): void
    {
        $param = [
            'id' => '',
        ];

        $token = $this->sanctumLogin(1);

        $this->assertAuthenticated();

        $response = $this->delete(config('api.host_name') . '/employee', $param, [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonStructure(['id']);

        $response->assertJson([
            "id" => [
                "The id field is required."
            ]
        ]);
    }
}
