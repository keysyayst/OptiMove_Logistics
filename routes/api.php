<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ShipmentController;

// AUTH ROUTES (tanpa middleware)
Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);

// ✅ PENTING: Taruh route generate-code SEBELUM route dengan {id}
Route::get('shipments/generate-code', [ShipmentController::class, 'generateCode']);

// PROTECTED ROUTES (dengan middleware auth:api)
Route::middleware('auth:api')->group(function () {
    Route::get('auth/me', [AuthController::class, 'me']);
    Route::post('auth/logout', [AuthController::class, 'logout']);

    // Shipments CRUD
    Route::get('shipments', [ShipmentController::class, 'index']);
    Route::post('shipments', [ShipmentController::class, 'store']);
    Route::get('shipments/{id}', [ShipmentController::class, 'show']);
    Route::put('shipments/{id}', [ShipmentController::class, 'update']);
    Route::delete('shipments/{id}', [ShipmentController::class, 'destroy']);
});
