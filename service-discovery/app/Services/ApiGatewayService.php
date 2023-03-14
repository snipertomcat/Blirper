<?php

namespace App\Services;

use App\DataObjects\RequestMessage;
use App\DataObjects\ResponseMessage;

interface ApiGatewayService
{
    public function generateTokens(): array;
    public function registerDefaultServices(): array;
    public function checkValidRequest(RequestMessage $requestMessage): bool;
    public function checkValidResponse(ResponseMessage $responseMessage): bool;
}
