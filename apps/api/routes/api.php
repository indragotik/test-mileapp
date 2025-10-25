<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

Route::middleware('api')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');

    Route::middleware('mock.auth')->group(function () {
        // resource tasks (GET/POST/PUT/DELETE) => /api/tasks
        Route::apiResource('tasks', TaskController::class);
    });
});

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::prefix('api')->middleware('api')->group(function () {
//     Route::post('/login', [AuthController::class, 'login']);
// });

// Route::middleware('mock.auth')->group(function () {
//     Route::apiResource('tasks', TaskController::class);
// });