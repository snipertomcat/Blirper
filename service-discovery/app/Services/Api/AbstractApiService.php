<?php

namespace App\Services\Api;

use App\Models\Token;
use App\Repositories\TokenRepository;
use App\Services\Api\Contracts\ApiRequestMessage;
use App\Services\Api\Contracts\ApiResponseMessage;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractApiService implements  ApiRequestMessage, ApiResponseMessage
{
    protected const SANCTUM_AUTHENTICATION_URI = '/api/sanctum/token';

    public function __construct(public TokenRepository $tokenRepository, public string $service="blirper")
    {
    }

    public function newFromToken(string $token, string $service): void
    {
        $this->tokenRepository->newFromToken($token, $service );
    }

    public function getToken(string $service): string
    {
        $prevToken = $this->tokenRepository->getExistingToken($service);
        if (isset($prevToken)) {
            return $prevToken->token;
        }
        $url = env('BLIRPER_ADDRESS') . '/' . static::SANCTUM_AUTHENTICATION_URI;
        $client = new Client();
        $response = $client->post($url, [
            'json' => [
                'email' => env('SERVICE_EMAIL'),
                'password' => env('SERVICE_PASSWORD'),
                'device_name' => "test"
            ]
        ]);

        $token = $response->getBody()->getContents();

        $this->newFromToken($token, $service);

        return $token;
    }

    public function buildRequest(string $token, string $endpoint, string $method): \Psr\Http\Message\ResponseInterface
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request($method, $endpoint, [
            'headers' => [
                'Authorization' => "Bearer " . $token
            ]
        ]);

        return $response;
    }

    public function parseResponse(ResponseInterface $response)
    {
        return $response->getBody()->getContents();
    }

}
