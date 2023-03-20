<?php

namespace App\Http\Controllers\Api;

use App\DataObjects\ServiceObject;
use App\Factories\ServiceFactory;
use App\Factories\TokenFactory;
use App\Http\Requests\RegisterServiceRequest;
use App\Jobs\CreateService;
use App\Jobs\CreateToken;
use App\Models\Service;
use App\Repositories\TokenRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Orion\Http\Controllers\Controller;

class ServiceController extends Controller
{
    protected $model = Service::class;

    public function __construct(
        private readonly ServiceFactory $serviceFactory,
        private readonly TokenFactory $tokenFactory,
        private readonly TokenRepository $tokenRepository)
    {
        parent::__construct();
    }

    /**
     * Registers a new service with the service-discovery system.
     * Will return any existing one before creating a new one
     *
     * @param RegisterServiceRequest $request
     * @return JsonResponse
     */
    public function register(RegisterServiceRequest $request): JsonResponse
    {
        $validated = $request->validated();
        //register service first
        $serviceObject = $this->serviceFactory->make($validated('name'));

        dispatch(new CreateService($serviceObject));

        //get the created record from DB (with dispatch() being an asynchronous)
        $serviceId = $this->tokenRepository->getTokenByService($validated('name'))->id;

        if (!is_null($serviceId)) {
            $tokenObject = $this->tokenFactory->make($request->except('name'));

            dispatch(new CreateToken($tokenObject));
            return new JsonResponse(['status' => 200]);
        }

        return new JsonResponse(['status' => 500, 'error' => "Service record could not be saved"]);
    }

    public function resolveUser()
    {
        return Auth::guard('sanctum')->user();
    }
}
