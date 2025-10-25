<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

Route::prefix("apis")->middleware('api')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])
        ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
});

Route::prefix("apis")->middleware('mock.auth')->group(function () {
    Route::apiResource('tasks', TaskController::class);
});