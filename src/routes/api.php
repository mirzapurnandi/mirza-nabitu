<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ReminderController;

Route::get('/', function () {
    return response()->json([
        'status' => true,
        'message' => 'Selamat Datang'
    ]);
});

Route::post('session', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::put('session', [AuthController::class, 'refreshToken']);

    Route::get('reminders', [ReminderController::class, 'index']);
    Route::post('reminders', [ReminderController::class, 'create']);
    Route::get('reminders/{id}', [ReminderController::class, 'view']);
    Route::put('reminders/{id}', [ReminderController::class, 'update']);
    Route::delete('reminders/{id}', [ReminderController::class, 'destroy']);
});
