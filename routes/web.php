<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NetworkServiceController;
use Illuminate\Http\Client\Request;

Route::get('/', function () {
    return view('app');
});

Route::post('/api/register', [AuthController::class, 'register']);
Route::post('/api/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/api/services', [NetworkServiceController::class, 'fetchNetworkServices']);
Route::get('/api/services/{service_id}', [NetworkServiceController::class, 'getNetworkService']);

