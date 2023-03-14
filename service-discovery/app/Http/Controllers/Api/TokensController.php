<?php

namespace App\Http\Controllers\Api;

use App\Jobs\CreateToken;
use App\Services\ServiceDiscovery;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Orion\Http\Controllers\Controller;
use App\Models\Token;

class TokensController extends Controller
{
    protected $model = Token::class;

    public function __construct(protected ServiceDiscovery $serviceDiscovery)
    {
        parent::__construct();
    }

    public function resolveUser()
    {
        return Auth::guard('sanctum')->user();
    }

    public function create(): JsonResponse
    {
        $tokens = $this->serviceDiscovery->generateTokens();

        foreach ($tokens as $token) {
            $this->dispatchSync(CreateToken::class, $token);
        }

        return new JsonResponse($tokens, 200);
    }
}
