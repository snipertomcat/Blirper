<?php

namespace App\Repositories;

use App\Jobs\CreateToken;
use App\Models\Service;
use App\Models\Token;

class TokenRepository
{
    public function getExistingToken($service)
    {
        return Token::query()
            ->where('name', $service)
            ->where('ttl', 0)
            ->first();
    }

    public function getAllTokens()
    {
        return Token::query()->get();
    }

    public function newFromToken($token, $service, $deviceType='service-discovery')
    {
        Token::create([
            'name' => $service,
            'token' => $token,
            'device_type' => $deviceType
        ]);
    }

    public function getTokenByService($name)
    {
        return Service::query()->where('name', $name)->first();
    }
}
