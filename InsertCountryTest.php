<?php

namespace Tests\Feature\Country;

use Database\Seeders\Test\CountryTestSeeder;
use Database\Seeders\Test\UserTestSeeder;
use Database\Seeders\Test\TenantTestSeeder;
use Illuminate\Http\Response;

use Tests\TestCase;

class InsertCountryTest extends TestCase
{
    /**
     * default setup method added with seeding the test database
     *
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->genericSetUp();
    }

    /**
     * test insert country route when used correctly
     */
    public function testInsertCountrySuccess()
    {
        $param = [
            "code"              => "TT",
            "code_3"            => "TTT",
            "name"              => "Test Country",
            'ccy'               => 'TTT',
            'airport_tax_code'  => 'TT',
            'phone_code'        => '00',
        ];

        $user = $this->sanctumLogin(1);

        $this->assertAuthenticated();

        $response = $this->post(config('ssso.my_api') . "/country", $param, []);

        $response->assertStatus(Response::HTTP_OK);

        $response->assertJsonStructure(['Operation Type', 'Status', 'data']);

        $response->assertJson(
            [
                "Operation Type" => "Insert Country",
                "Status" => "Success",
                "data" => [
                    "code"              => "TT",
                    "code_3"            => "TTT",
                    "name"              => "Test Country",
                    'ccy'               => 'TTT',
                    'airport_tax_code'  => 'TT',
                    'phone_code'        => '00',
                ]
            ]
        );

        $this->assertDatabaseHas('country', [
            "code"              => "TT",
            "code_3"            => "TTT",
            "name"              => "Test Country",
            'ccy'               => 'TTT',
            'airport_tax_code'  => 'TT',
            'phone_code'        => '00',
            "tenant_id" => 1,
            "create_by" => 1
        ]);

        $this->assertDatabaseHas('master_history', [
            "id" => 1
        ]);

        $this->assertDatabaseMissing('master_history', [
            "id" => 2
        ]);

        $this->assertDatabaseHas('api_history', [
            "id" => 1,
            "method" => "POST",
            "status_code" => 200
        ]);

        $this->assertDatabaseMissing('api_history', [
            "id" => 2
        ]);
    }

    /**
     * test insert country route when the input is either empty or not given at all
     */
    public function testInsertCountryRulesRequiredFailed()
    {
        $param = [
            "code"              => "",
            "code_3"            => "",
            "name"              => "",
            'ccy'               => '',
            'airport_tax_code'  => '',
            'phone_code'        => '',
        ];

        $user = $this->sanctumLogin(1);

        $this->assertAuthenticated();

        $response = $this->post(config('ssso.my_api') . "/country", $param, []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonStructure(
            [
                'code',
                'code_3',
                'name',
                'ccy',
                'airport_tax_code',
                'phone_code',
            ]
        );

        $response->assertJson(
            [
                "code" => [
                    "The code field is required."
                ],
                "code_3" => [
                    "The code 3 field is required."
                ],
                "name" => [
                    "The name field is required."
                ],
                "ccy" => [
                    "The ccy field is required."
                ],
                "airport_tax_code" => [
                    "The airport tax code field is required."
                ],
                "phone_code" => [
                    "The phone code field is required."
                ],
            ]
        );

        $this->assertDatabaseHas('country', [
            "id" => 2
        ]);

        $this->assertDatabaseMissing('country', [
            "id" => 3
        ]);

        $this->assertDatabaseMissing('master_history', [
            "id" => 1
        ]);

        $this->assertDatabaseHas('api_history', [
            "id" => 1,
            "method" => "POST",
            "status_code" => 422
        ]);

        $this->assertDatabaseMissing('api_history', [
            "id" => 2
        ]);
    }

    /**
     * test insert country route when the input is not as expected (rules failed but input given)
     */
    public function testInsertCountrySpecificRulesFailed()
    {
        $param = [
            "code"              => "sadadwqdsad",
            "code_3"            => "dsavqwcsazx",
            "name"              => "faksjfn!kaf?}",
            'ccy'               => 'dasvadrasdafasfas',
            'airport_tax_code'  => 'asfasfwqsavaasfas',
            'phone_code'        => 'qweqdsafasfqwfqfs',
        ];

        $user = $this->sanctumLogin(1);

        $this->assertAuthenticated();



        $response = $this->post(config('ssso.my_api') . "/country", $param, []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $response->assertJsonStructure(
            [
                'code',
                'code_3',
                'name',
                'ccy',
                'airport_tax_code',
                'phone_code',
            ]
        );

        $response->assertJson(
            [
                "code" => [
                    "The code field must be 2 characters."
                ],
                "code_3" => [
                    "The code 3 field must be 3 characters."
                ],
                "name" => [
                    config('error_message')["name.regex"]
                ],
                "ccy" => [
                    "The ccy field must be 3 characters."
                ],
                "airport_tax_code" => [
                    "The airport tax code field must not be greater than 3 characters."
                ],
                "phone_code" => [
                    config('error_message')["phone_code.regex"]
                ],
            ]
        );

        $this->assertDatabaseHas('country', [
            "id" => 2
        ]);

        $this->assertDatabaseMissing('country', [
            "id" => 3
        ]);

        $this->assertDatabaseMissing('master_history', [
            "id" => 1
        ]);

        $this->assertDatabaseHas('api_history', [
            "id" => 1,
            "method" => "POST",
            "status_code" => 422
        ]);

        $this->assertDatabaseMissing('api_history', [
            "id" => 2
        ]);
    }
}
