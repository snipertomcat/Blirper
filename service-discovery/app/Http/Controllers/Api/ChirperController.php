<?php

namespace App\Http\Controllers\Api;

use App\Models\Service;
use App\Services\Api\ChirperService;
use App\Services\ServiceDiscovery;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class ChirperController extends Controller
{
    public function __construct(protected ChirperService $chirper)
    {

    }

    public function index()
    {
        $blirps = $this->chirper->read();
    }

    public function resolveUser()
    {
        return Auth::guard('sanctum')->user();
    }
}
