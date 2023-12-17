<?php

use App\Enums\TokenAbility;
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

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::put('session', [AuthController::class, 'refreshToken'])->middleware('ability:' . TokenAbility::ISSUE_ACCESS_TOKEN->value);

    Route::get('reminders', [ReminderController::class, 'index'])->middleware('ability:' . TokenAbility::ACCESS_API->value);
    Route::post('reminders', [ReminderController::class, 'create'])->middleware('ability:' . TokenAbility::ACCESS_API->value);
    Route::get('reminders/{id}', [ReminderController::class, 'view'])->middleware('ability:' . TokenAbility::ACCESS_API->value);
    Route::put('reminders/{id}', [ReminderController::class, 'update'])->middleware('ability:' . TokenAbility::ACCESS_API->value);
    Route::delete('reminders/{id}', [ReminderController::class, 'destroy'])->middleware('ability:' . TokenAbility::ACCESS_API->value);

    //optional
    Route::get('session/profile', [AuthController::class, 'profile'])->middleware('ability:' . TokenAbility::ACCESS_API->value);
    Route::post('session/logout', [AuthController::class, 'logout'])->middleware('ability:' . TokenAbility::ACCESS_API->value);
});
