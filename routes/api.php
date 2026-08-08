<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\BuildingApiController;
use App\Http\Controllers\Api\ClassroomApiController;



Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthApiController::class, 'logout']);
    Route::get('/user', [AuthApiController::class, 'userProfile']);

    Route::apiResource('/buildings', BuildingApiController::class);
    Route::apiResource('/classrooms', ClassroomApiController::class);

});
