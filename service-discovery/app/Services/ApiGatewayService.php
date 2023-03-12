<?php

namespace App\Services;

use App\DataObjects\RequestMessage;
use App\DataObjects\ResponseMessage;

interface ApiGatewayService
{
    public function generateTokens(): void;
    public function registerServices(): void;
    public function checkValidRequest(RequestMessage $requestMessage): bool;
    public function checkValidResponse(ResponseMessage $responseMessage): bool;
}
