<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

Route::get('/', function () {
    return response()->json([
        'status' => true,
        'message' => 'Selamat Datang'
    ]);
});

Route::post('session', [AuthController::class, 'login']);
