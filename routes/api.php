<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ShipmentController;
use App\Models\Shipment;

// AUTH: boleh diakses tanpa login
Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login',    [AuthController::class, 'login']);

// GENERATE KODE (public)
Route::get('shipments/generate-code', function () {
    return response()->json([
        'code' => Shipment::generateCode(),
    ]);
});

// BUTUH JWT
Route::middleware('auth:api')->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('auth/me',      [AuthController::class, 'me']);

    Route::apiResource('shipments', ShipmentController::class);
});

