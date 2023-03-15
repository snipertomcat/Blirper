<?php

namespace App\Services\Api\Contracts;

use Psr\Http\Message\ResponseInterface;

interface ApiRequestMessage
{
    public function buildRequest(string $token, string $endpoint, string $method): ResponseInterface;
}
