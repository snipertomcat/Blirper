<?php

namespace App\DataObjects;

class ServiceObject implements DataObjectContract
{
    public function __construct(
        public readonly string $name
    ){}

    public function toArray(): array
    {
        return [
            'name' => $this->name
        ];
    }

    public function toJson(): string
    {
        return json_encode([
            'name' => $this->name
        ]);
    }
}
