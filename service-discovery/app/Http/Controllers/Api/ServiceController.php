<?php

namespace App\Http\Controllers\Api;

use App\DataObjects\ServiceObject;
use App\Factories\ServiceFactory;
use App\Http\Requests\RegisterServiceRequest;
use App\Jobs\CreateService;
use App\Jobs\CreateToken;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Orion\Http\Controllers\Controller;

class ServiceController extends Controller
{
    protected $model = Service::class;

    public function __construct(
        private readonly ServiceFactory $serviceFactory,
        private readonly CreateService $createServiceCommand,
        private readonly CreateToken $createTokenCommand)
    {
        parent::__construct();
    }

    /**
     * Registers a new service with the service-discovery system.
     * Will return any existing one before creating a new one
     * // TODO: create cron job to purge service registration records if they are passed their expiration (services.ttl)
     *
     * @param RegisterServiceRequest $request
     * @return JsonResponse
     */
    public function register(RegisterServiceRequest $request): JsonResponse
    {
        $serviceObject = $this->serviceFactory->make($request->validated());

        $command = new $this->createServiceCommand($serviceObject);

        $this->dispatch($command);

        dd($service);
    }

    public function resolveUser()
    {
        return Auth::guard('sanctum')->user();
    }
}
