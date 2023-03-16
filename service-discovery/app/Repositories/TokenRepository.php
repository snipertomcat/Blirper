<?php

namespace App\Repositories;

use App\Jobs\CreateToken;
use App\Models\Token;

class TokenRepository
{
    public function getExistingToken($service)
    {
        return Token::query()
            ->where('service', $service)
            ->where('ttl', 0)
            ->first();
    }

    public function newFromToken($token, $service, $deviceType='service-discovery')
    {
        $params = [
            'service' => $service,
            'token' => $token,
            'device_type' => $deviceType
        ];

        return dispatch(new CreateToken($params));
    }
}
