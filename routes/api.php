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

    Route::get('/orders/{order}', [OrderController::class, 'show'])->middleware('role:kasir,pelayan');
});

Route::middleware(['auth:sanctum', 'role:kasir'])->group(function () {
    Route::post('/foods', [FoodController::class, 'store']);
    Route::put('/foods/{food}', [FoodController::class, 'update']);
    Route::delete('/foods/{food}', [FoodController::class, 'destroy']);
    
    Route::get('/orders', [OrderController::class, 'index']);
    Route::patch('/orders/{order}/close', [OrderController::class, 'close']);
    Route::get('/orders/{order}/receipt', [OrderController::class, 'receipt']);
});

Route::middleware('auth:sanctum', 'role:pelayan')->group(function () {
    Route::post('/orders', [OrderController::class, 'store']);
    Route::post('/orders/{order}/items', [OrderController::class, 'addItem']);
    Route::put('/orders/{order}/items/{item}', [OrderController::class, 'updateItem']);
    Route::delete('/orders/{order}/items/{item}', [OrderController::class, 'deleteItem']);
});
    
Route::get('/tables', [TableController::class, 'index']);
Route::get('/foods', [FoodController::class, 'index']);
Route::get('/foods/{food}', [FoodController::class, 'show']);