<?php

namespace App\Http\Controllers\Api;

use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Orion\Http\Controllers\Controller;

class ServiceController extends Controller
{
    protected $model = Service::class;

    public function resolveUser()
    {
        return Auth::guard('sanctum')->user();
    }
}
