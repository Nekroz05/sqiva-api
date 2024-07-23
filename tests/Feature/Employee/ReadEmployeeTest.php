<?php

namespace Tests\Feature\Employee;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class ReadEmployeeTest extends TestCase
{
    public function testReadEmployeeSuccess(): void
    {
        $this->sanctumLogin(1);

        $this->assertAuthenticated();

        $response = $this->get(config('api.host_name') . '/employee/find-all');

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure(['code', 'message', 'data']);
    }
}
