<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\WarehouseController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\InventoryMovementController;

Route::apiResource('warehouses', WarehouseController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('inventory-movements', InventoryMovementController::class);
