<?php

namespace App\Services\Api\Contracts;

use Psr\Http\Message\ResponseInterface;

// TODO : move this and all other contracts to the App\Contracts
interface ApiRequestMessage
{
    public function buildRequest(string $token, string $endpoint, string $method): ResponseInterface;
}
