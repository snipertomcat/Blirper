<?php

namespace App\DataObjects;

class ResponseMessage
{

    public function __construct(
        public readonly ?array $header,
        public readonly string $message
    )
    {
    }
}
