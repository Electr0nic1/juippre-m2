<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GagarinController;
use App\Http\Controllers\LunarMissionController;
use App\Http\Controllers\SpaceFlightsController;
use App\Http\Controllers\WaterMarkController;
use Illuminate\Support\Facades\Route;

Route::post('/registration', [AuthController::class, 'registration']);
Route::post('/authorization', [AuthController::class, 'authorization']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::post('/lunar-missions', [LunarMissionController::class, 'store']);
    Route::get('/lunar-missions', [LunarMissionController::class, 'index']);
    Route::get('/lunar-missions/{id}', [LunarMissionController::class, 'show']);
    Route::delete('/lunar-missions/{id}', [LunarMissionController::class, 'destroy']);
    Route::patch('/lunar-missions/{id}', [LunarMissionController::class, 'update']);
    Route::get('/search', [LunarMissionController::class, 'search']);

    Route::post('/space-flights', [SpaceFlightsController::class, 'store']);
    Route::get('/space-flights', [SpaceFlightsController::class, 'index']);
    Route::post('/book-flight', [SpaceFlightsController::class, 'book']);

    Route::get('/gagarin-flight', [GagarinController::class, '__invoke']);

    Route::post('/lunar-watermark', [WatermarkController::class, '__invoke']);
});



