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
        /*$serviceRegistry = [];
        $serviceDiscovery = new ServiceDiscovery();
        if (is_null($serviceDiscovery)) {
            throw new \Exception("Cannot create service discovery class without settings");
        }
        $chirperServiceParams = $serviceDiscovery->getServices()['blirper'];*/

        dd( $this->chirper->getAllBlirps());
    }

    public function resolveUser()
    {
        return Auth::guard('sanctum')->user();
    }
}
