<?php

namespace App\Services;

use App\DataObjects\RequestMessage;
use App\DataObjects\ResponseMessage;

class ServiceDiscovery implements ApiGatewayService
{
    protected $services = [];

    public function __construct()
    {

    }

    public function generateTokens(): void
    {
        // TODO: Implement generateTokens() method.
    }

    public function registerServices(): void
    {
        // TODO: Implement registerServices() method.
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
