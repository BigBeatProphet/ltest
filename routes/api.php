<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\BusController;
use App\Http\Controllers\Api\StopController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\RouteController;
use App\Http\Controllers\Api\FindController;

Route::apiResource('buses', BusController::class);
Route::apiResource('stops', StopController::class);
Route::apiResource('schedules', ScheduleController::class);
Route::apiResource('routes', RouteController::class);
Route::get('/find-bus', [FindController::class, 'findBus']);
Route::put('/routes/{routeId}', [FindController::class, 'updateRoute']);
Route::post('/routes/update/{id}', [RouteController::class, 'update']);