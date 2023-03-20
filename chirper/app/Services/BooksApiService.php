<?php

namespace App\Services;

use App\Services\Api\AbstractApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BooksApiService extends AbstractApiService
{
    public const BOOK_SERVICE_URL = 'localhost:8000/api';

    public function index()
    {
        if (!is_null($apiUrl = env('BOOK_SERVICE_API'))) {
            $url = $apiUrl;
        } else {
            $url = self::BOOK_SERVICE_URL;
        }

        $token = $this->getToken($url."/sanctum/token");
    }

}
