<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\WarehouseController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\InventoryMovementController;
use App\Http\Controllers\API\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('warehouses', WarehouseController::class);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('inventory-movements', InventoryMovementController::class);
});

use App\Http\Controllers\API\MarketplaceController;

Route::get('/marketplace/accounts', [MarketplaceController::class, 'index']);
Route::post('/marketplace/accounts', [MarketplaceController::class, 'store']);
Route::get('/marketplace/wb/orders', [MarketplaceController::class, 'syncWbOrders']);
