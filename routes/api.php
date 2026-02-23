<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FoodController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\TableController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::apiResource('foods', FoodController::class);
    
    Route::post('/orders', [OrderController::class, 'store'])
        ->middleware('role:pelayan');

    Route::post('/orders/{order}/items', [OrderController::class, 'addItem'])
        ->middleware('role:pelayan');

    Route::patch('/orders/{order}/close', [OrderController::class, 'close'])
        ->middleware('role:kasir');
    });
    
Route::get('/tables', [TableController::class, 'index']);