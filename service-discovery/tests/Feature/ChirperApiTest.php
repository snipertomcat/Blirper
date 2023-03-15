<?php

namespace Tests\Feature;

use GuzzleHttp\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChirperApiTest extends TestCase
{
    public function setUp(): void
    {
        $this->chirperAddress = env('BLIRPER_ADDRESS');
        $this->token = $this->getToken('blirper');
        parent::setUp();
    }

    public function test_can_ping_chirper_health_check_endpoint(): void
    {
        $client = new Client();
        $response = $client->get( env('BLIRPER_ADDRESS') . '/health-check');
        $healthCheck = $response->getBody()->getContents();
        $this->assertNotFalse($healthCheck);
    }

    /**
     * Retrieve token used for the rest of the tests
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function getToken(): string
    {
        if (!isset($this->token)) {
            $client = new Client();
            $response = $client->post(env('BLIRPER_ADDRESS') . '/api/sanctum/token', [
                'json' => [
                    'email' => env('SERVICE_EMAIL'),
                    'password' => env('SERVICE_PASSWORD'),
                    'device_name' => "test"
                ]
            ]);

        } else {
            return $this->token;
        }

        return trim($response->getBody()->getContents());
    }

    public function test_can_retrieve_blirp_data_with_token()
    {
        $client = new Client();
        $token = $this->getToken('blirper');
        $response = $client->get(env('BLIRPER_ADDRESS').'/api/blirps', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token
            ]
        ]);

        $blirps = $response->getBody()->getContents();

        $this->assertNotEmpty($blirps);
    }
}
