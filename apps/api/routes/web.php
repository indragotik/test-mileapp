<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return response()->json([
        'message' => 'MileApp API',
        'version' => '1.0.0',
        'status' => 'running'
    ]);
});

Route::get('/test', function () {
    return "This is a test route";
});

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login'])
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

Route::middleware('mock.auth')->group(function () {
    Route::apiResource('tasks', TaskController::class);
});
