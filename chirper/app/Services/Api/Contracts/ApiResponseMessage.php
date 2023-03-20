<?php

namespace App\Services\Api\Contracts;

use Psr\Http\Message\ResponseInterface;

interface ApiResponseMessage
{
    public function parseResponse(ResponseInterface $response);
}
