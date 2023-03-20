<?php

namespace App\Services\Api;

use http\Client;
use Illuminate\Support\Facades\Validator;
use Psr\Http\Message\ResponseInterface;

class ChirperService extends AbstractApiService implements ApiBasicCrud
{
    public const CHIRPER_DEFAULT_ADDRESS = 'http://localhost:85';

    public function read(int $id = null): string
    {
        //retrieve an existing token or create a new one (handled in the parent class)
        $token = $this->getToken('blirper');

        if (is_null($id)) {
            $endpoint = static::CHIRPER_DEFAULT_ADDRESS . '/api/blirps';
        } else {
            $endpoint = static::CHIRPER_DEFAULT_ADDRESS . '/api/blirps/' . $id;
        }

        $builtRequest = $this->buildRequest($token, $endpoint, 'GET');

        return $builtRequest->getBody()->getContents();
    }

    public function delete(int $id): string
    {
        $token = $this->getToken('blirper');

        $endpoint = (env('BLIRPER_ADDRESS') ?? 'http:localhost:85') . '/api/blirps/' . $id;

        return $this->buildRequest($token, $endpoint, 'DELETE')
            ->getBody()
            ->getContents();
    }

    public function create(array $params): ResponseInterface
    {
        $token = $this->getToken('blirper');

        $validated = Validator::validate($params, [
            'user_id' => 'required|int',
            'message' => 'required|string'
        ]);

        $endpoint = $this->getBaseUrl() . 'blirps';

        return $this->buildRequest($token, $endpoint, 'POST', $validated);
    }


    public function update(array $params): ResponseInterface
    {
        $token = $this->getToken('blirper');

        $validated = Validator::validate($params, [
            'message' => 'string',
            'user_id' => 'int'
        ]);

        $endpoint = $this->getBaseUrl() . 'blirps';

        return $this->buildRequest($token, $endpoint, 'PATCH', $validated);
    }

    private function getBaseUrl(): string
    {
        return (env('BLIRPER_ADDRESS') ?? 'http://localhost:85') . '/api/blirps/';
    }
}
