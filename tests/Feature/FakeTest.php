<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Client\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class FakeTest extends TestCase
{
    public function testFake(): void
    {
        $params = [
            'username'              => 'indraoei',
            'password'              => 'password',
            'tenant_identifier'     => 'sqiva.com'
        ];

        Http::fake([
            'https://sso.sqiva.com/api/v1/authentication/login' => Http::response([
                'message' => 'Kena Fake'
            ], 200)
        ]);

        $response = Http::post('https://sso.sqiva.com/api/v1/authentication/login', $params);

        Http::assertSentCount(1);

        $response->json()['message'];
    }
}
