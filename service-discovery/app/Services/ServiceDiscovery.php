<?php

namespace App\Services;

use App\DataObjects\RequestMessage;
use App\DataObjects\ResponseMessage;
use App\Repositories\TokenRepository;
use GuzzleHttp\Client;
use JsonException;

class ServiceDiscovery implements ApiGatewayService
{
    protected $services = [];

    /**
     * @param TokenRepository $tokenRepository
     */
    public function __construct(private readonly TokenRepository $tokenRepository)
    {
        $this->tokens = $this->tokenRepository->getAllTokens();
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

    public function registerDefaultServices(): array
    {
        // TODO: Implement registerDefaultServices() method.
    }
}
