<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
