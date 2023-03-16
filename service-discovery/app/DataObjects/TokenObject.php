<?php

namespace App\DataObjects;

class TokenObject implements DataObjectContract
{
    public function __construct(
        public readonly string $serviceId,
        public readonly string $token,
        public readonly string $address,
        public readonly string $deviceType
    ){}

    public function toArray(): array
    {
        return [
            'serviceId' => $this->serviceId,
            'token' => $this->token,
            'address' => $this->address,
            'deviceType' => $this->deviceType
        ];
    }

    public function toJson(): string
    {
        return json_encode([
            'serviceId' => $this->serviceId,
            'token' => $this->token,
            'address' => $this->address,
            'deviceType' => $this->deviceType
        ], JSON_THROW_ON_ERROR);
    }
}
