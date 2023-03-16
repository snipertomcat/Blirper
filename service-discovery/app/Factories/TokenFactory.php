<?php

namespace App\Factories;

use App\DataObjects\DataObjectContract;
use App\DataObjects\TokenObject;
use Illuminate\Support\Arr;

class TokenFactory
{
    public function make(array $data): DataObjectContract
    {
        return new TokenObject(
            serviceId: Arr::get($data, 'service_id'),
            token: Arr::get($data, 'token'),
            address: Arr::get($data, 'address'),
            deviceType: Arr::get($data, 'device_type')
        );
    }
}
