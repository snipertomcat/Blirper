<?php

namespace App\Services\Api;

use http\Client;

class ChirperService extends AbstractApiService
{
    public function getAllBlirps(): \Psr\Http\Message\ResponseInterface
    {
        $token = $this->getToken('blirper');

        $endpoint = env('BLIRPER_ADDRESS') . '/api/blirps';

        return $this->buildRequest($token, $endpoint, 'GET');
    }

    public function delete()
    {

    }

    public function create()
    {

    }


}
