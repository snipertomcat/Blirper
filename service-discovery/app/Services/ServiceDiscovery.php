<?php

namespace App\Services;

use App\DataObjects\RequestMessage;
use App\DataObjects\ResponseMessage;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use JsonException;

class ServiceDiscovery implements ApiGatewayService
{
    protected $services = [];

    protected $tokens = [];

    /**
     * @throws JsonException
     */
    public function __construct()
    {
        $services = $this->registerDefaultServices();
        $this->services = $services;
    }

    public function generateTokens(): void
    {
        foreach ($this->services as $service) {
            $guzzle = new Client();
            $url = $service['address'] . '/api/sanctum/token';
            $response = $guzzle->request(         'POST', $url, [
                'json' => [
                    'email' => env('SERVICE_EMAIL') ?? 'hemham914@gmail.com',
                    'password' => env('SERVICE_PASSWORD') ?? 'yeahyeah',
                    'device_name' => $service['name'] ?? 'service-discovery'
                ],
                'headers' => [
                    'CONTENT_TYPE' => 'application/json'
                ]
            ]);
            $token = $response->getBody()->getContents();
            //update services array with token for each service
            $this->tokens[$service['name']]['token'] = $token;
        }
    }

    public function registerDefaultServices(): array
    {
        return  [
            [
                'name' => env('BLIRPER_SERVICE_NAME') ?? 'blirper',
                'address' => env('BLIRPER_ADDRESS') ?? 'http://chirper.test',
            ],
            [
                'name' => env('USER_CONTEXT_NAME') ?? 'users',
                'address' => env('USER_CONTEXT_ADDRESS') ?? 'http://user-context.test',
            ]
        ];
    }

    public function getServices()
    {
        return $this->services;
    }

    public function getTokens()
    {
        return $this->tokens;
    }

    public function checkValidRequest(RequestMessage $requestMessage): bool
    {
        // TODO: Implement checkValidRequest() method.
    }

    public function checkValidResponse(ResponseMessage $responseMessage): bool
    {
        // TODO: Implement checkValidResponse() method.
    }
}
