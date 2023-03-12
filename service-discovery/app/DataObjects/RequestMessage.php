<?php

namespace App\DataObjects;

class RequestMessage
{

    public function __construct(
        public readonly ?array $headers,
        public readonly ?string $contentType,
        public readonly string $message,
    )
    {
    }
}
