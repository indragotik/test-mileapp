<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    require __DIR__ . "/../public/index.php";
    return "";
});

Route::middleware('api')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('mock.auth')->group(function () {
    Route::apiResource('tasks', TaskController::class);
});