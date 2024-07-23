<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testLoginSuccess(): void
    {
        $param = [
            'email'            => 'indraoei25@gmail.com',
            'password'         => 'asdasd',
        ];

        $user = $this->sanctumLogin(1);

        $this->assertAuthenticated();

        $response = $this->post(config('api.host_name') . '/auth/login', $param, []);

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure(['code', 'message', 'data']);
    }
}
