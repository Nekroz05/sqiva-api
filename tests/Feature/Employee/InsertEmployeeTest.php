<?php

namespace Tests\Feature\Employee;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class InsertEmployeeTest extends TestCase
{
    public function testInsertEmployeeSuccess(): void
    {
        $param = [
            'first_name'    => 'George',
            'last_name'     => 'Jameson',
            'email'         => 'georgejameson@gmail.com',
            'password'      => 'asdasd',
            'age'           => '20',
            'weight'        => '60 kg',
        ];

        $this->sanctumLogin(1);

        $this->assertAuthenticated();

        $response = $this->post(config('api.host_name') . '/employee', $param, []);

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure(['code', 'message', 'data']);

        // Check if data will be found in database
        $this->assertDatabaseHas('employee', [
            'team_id'           => 1,
            'first_name'        => "George",
            'last_name'         => "Jameson",
            'email'             => "georgejameson@gmail.com",
            'age'               => '20',
            'weight'            => '60 kg',
            'create_by'         => 1
        ]);
    }

    public function testInsertEmployeeFailed()
    {
        $param = [
            'first_name'    => '',
            'last_name'     => '',
            'email'         => '',
            'password'      => '',
            'age'           => '',
            'weight'        => '',
        ];

        $this->sanctumLogin(1);

        $this->assertAuthenticated();

        $response = $this->post(config('api.host_name') . '/employee', $param, []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonStructure(
            [
                'first_name',
                'last_name',
                'email',
                'password',
                'age',
                'weight',
            ]
        );

        $response->assertJson(
            [
                "first_name" => [
                    "The first name field is required."
                ],
                "last_name" => [
                    "The last name field is required."
                ],
                "email" => [
                    "The email field is required."
                ],
                "password" => [
                    "The password field is required."
                ],
                "age" => [
                    "The age field is required."
                ],
                "weight" => [
                    "The weight field is required."
                ]
            ]
        );
    }
}
