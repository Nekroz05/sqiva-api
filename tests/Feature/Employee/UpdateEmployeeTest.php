<?php

namespace Tests\Feature\Employee;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class UpdateEmployeeTest extends TestCase
{
    public function testUpdateEmployeeSuccess(): void
    {
        $param = [
            'first_name'    => 'George 2',
            'last_name'     => 'Jameson',
            'email'         => 'georgejameson@gmail.com',
            'password'      => 'asdasd',
            'age'           => '20',
            'weight'        => '60 kg',
        ];

        $this->sanctumLogin(1);

        $this->assertAuthenticated();

        $response = $this->patch(config('api.host_name') . '/employee/2', $param, []);

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure(['code', 'message', 'data']);

        $this->assertDatabaseHas('employee', [
            'team_id'           => 1,
            'first_name'        => "George 2",
            'last_name'         => "Jameson",
            'email'             => "georgejameson@gmail.com",
            'age'               => '20',
            'weight'            => '60 kg'
        ]);
    }

    public function testUpdateEmployeeFailed()
    {
        $param = [
            'id'            => '',
            'first_name'    => '',
            'last_name'     => '',
            'email'         => '',
            'password'      => '',
            'age'           => '',
            'weight'        => '',
        ];

        $this->sanctumLogin(1);

        $this->assertAuthenticated();

        $response = $this->patch(config('api.host_name') . '/employee/3', $param, []);

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
