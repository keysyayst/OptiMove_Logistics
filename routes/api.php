<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ShipmentController;
use App\Http\Controllers\Api\TrackingController;

Route::post('auth/register', [AuthController::class, 'register']);
Route::post('auth/login', [AuthController::class, 'login']);

Route::get('tracking/uuid/{uuid}', [TrackingController::class, 'getByShipmentUuid']);
Route::get('tracking/code/{code}', [TrackingController::class, 'getByShipmentCode']);

Route::get('shipments/generate-code', [ShipmentController::class, 'generateCode']);

Route::middleware('auth:api')->group(function () {
    Route::get('auth/me', [AuthController::class, 'me']);
    Route::post('auth/logout', [AuthController::class, 'logout']);

    Route::get('shipments', [ShipmentController::class, 'index']);
    Route::post('shipments', [ShipmentController::class, 'store']);
    Route::get('shipments/{id}', [ShipmentController::class, 'show']);
    Route::put('shipments/{id}', [ShipmentController::class, 'update']);
    Route::delete('shipments/{id}', [ShipmentController::class, 'destroy']);

    Route::post('tracking', [TrackingController::class, 'store']);
    Route::put('tracking/{uuid}', [TrackingController::class, 'update']);
    Route::delete('tracking/{uuid}', [TrackingController::class, 'destroy']);
});
