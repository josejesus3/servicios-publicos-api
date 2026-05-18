<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IncidentController;
use Illuminate\Support\Facades\Route;



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
//////////////////////////////////////////////////////////
Route::middleware('auth:api')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('/incident', IncidentController::class);

    Route::middleware('admin')->group(function () {
        Route::patch('/users/{user}', [AuthController::class, 'updateUser']);
    });

});