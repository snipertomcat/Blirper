<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Orion\Facades\Orion;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('health_check', function() {
    return new \Illuminate\Http\Response("OK", 200);
});

Route::group(['as' => 'api.'], function() {
    Orion::resource('services', \App\Http\Controllers\Api\ServiceController::class);
    Route::get('all-blirps', "App\Http\Controllers\Api\ChirperController@index");
    Route::post('services/register', "App\Http\Controllers\Api\ServiceController@register");
})->middleware('auth:sanctum');


Route::post('/sanctum/token', static function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    return $user->createToken($request->device_name)->plainTextToken;
});

