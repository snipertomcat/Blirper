<?php

namespace App\Services\Api;

use App\Services\Api\Contracts\ApiRequestMessage;
use App\Services\Api\Contracts\ApiResponseMessage;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractApiService implements  ApiRequestMessage, ApiResponseMessage
{
    protected const SANCTUM_AUTHENTICATION_URI = 'api/sanctum/token';

    public function __construct()
    {
    }

    abstract public function index();

    final public function getToken(string $url): string
    {
        $client = new Client();
        $response = $client->post($url, [
            'json' => [
                'email' => env('SERVICE_EMAIL') ?? 'hemham914@gmail.com',
                'password' => env('SERVICE_PASSWORD') ?? 'yeahyeah',
                'device_name' => 'sd'
            ],
            'headers' => [
                'CONTENT_TYPE' => 'application/json'
            ]
        ]);

        $token = $response->getBody()->getContents();

        //cache token
        Cache::remember('retrieve_api_token', 15000, function () use ($token) {
            return $token;
        });

        return $token;
    }

    public function buildRequest(string $token, string $endpoint, string $method, array $body = []): \Psr\Http\Message\ResponseInterface
    {
        $client = new \GuzzleHttp\Client();
        if (empty($body)) {
            $response = $client->request($method, $endpoint, [
                'headers' => [
                    'Authorization' => "Bearer " . $token,
                    "Content-Type" => "application/json"
                ]
            ]);
        } else {
            $response = $client->request($method, $endpoint, [
                'headers' => [
                    'Authorization' => "Bearer " . $token,
                    'Content-Type' => "application/json"
                ],
                'json' => $body
            ]);
        }

        return $response;
    }

    public function parseResponse(ResponseInterface $response)
    {
        return $response->getBody()->getContents();
    }

}
