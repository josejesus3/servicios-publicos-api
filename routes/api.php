<?php

use App\Http\Controllers\AdministradorController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IncidentController;
use Illuminate\Support\Facades\Route;



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
 Route::apiResource('/areas',AreaController::class);
 Route::get('/getIncident',[IncidentController::class,'getIncident']);
//////////////////////////////////////////////////////////
Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('/incident', IncidentController::class);
    Route::middleware('admin')->group(function () {
        Route::get('/users',[AdministradorController::class,'getUsuarios']);
        Route::get('/areasAll',[AdministradorController::class,'getAreas']);
        Route::patch('/users/{user}', [AuthController::class, 'updateUser']);
    });

});