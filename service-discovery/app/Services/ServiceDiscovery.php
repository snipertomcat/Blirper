<?php

namespace App\Services;

use App\DataObjects\RequestMessage;
use App\DataObjects\ResponseMessage;
use GuzzleHttp\Client;
use JsonException;

class ServiceDiscovery implements ApiGatewayService
{
    protected $services = [];

    /**
     * @throws JsonException
     */
    public function __construct()
    {
        $services = $this->registerDefaultServices();
        $this->services = $services;
    }

    public function generateTokens(): array
    {
        $tokens = [];
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
            $tokenString = $response->getBody()->getContents();
            $tokenString = trim($tokenString);
            $tokenArray = [
                'service' => $service['name'],
                'device_type' => 'service-discovery',
                'token' => $tokenString,
                'address' => $service['address']
            ];

            $tokens[$service['name']] = $tokenArray;
        }

        return $tokens;
    }

    public function registerDefaultServices(): array
    {
        return  [
            [
                'name' => env('BLIRPER_SERVICE_NAME') ?? 'blirper',
                'address' => env('BLIRPER_ADDRESS') ?? 'http://localhost:85',
            ],
        /*    [
                'name' => env('USER_CONTEXT_NAME') ?? 'users',
                'address' => env('USER_CONTEXT_ADDRESS') ?? 'http://user-context.test',
            ]*/
        ];
    }

    public function getServices()
    {
        $serviceRegistry = [];
        foreach ($this->services as $service) {
             $serviceRegistry[$service['name']] = $service;
        }
        return $serviceRegistry;
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
