<?php

namespace App\Http\Controllers\Api;

use App\Models\Blirp;
use Illuminate\Support\Facades\Auth;
use Orion\Http\Controllers\Controller;

class BlirpController extends Controller
{
    protected $model = \App\Models\Blirp::class;

    public function resolveUser()
    {
        return Auth::guard('sanctum')->user();
    }
}
