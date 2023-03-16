<?php

namespace App\DataObjects;

class ServiceObject implements DataObjectContract
{
    public function __construct(
        public readonly string $name,
        public readonly string $token,
        public readonly string $address,
        public readonly string $deviceType
    ){}

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'token' => $this->token,
            'address' => $this->address,
            'deviceType' => $this->deviceType
        ];
    }

    public function toJson(): string
    {
        return json_encode([
            'name' => $this->name,
            'token' => $this->token,
            'address' => $this->address,
            'deviceType' => $this->deviceType
        ]);
    }
}
