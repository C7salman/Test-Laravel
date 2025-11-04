<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

// مجموعة API القياسية لمسارات REST
Route::middleware(['api'])->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    // نقاط نهاية مصادقة مبنية على الكوكيز لـ Sanctum (SPA)
    Route::post('session/login', [AuthController::class, 'sessionLogin']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'me']);

        // نقاط نهاية الجلسة للمصادقة بالكوكيز بعد تسجيل الدخول
        Route::post('session/logout', [AuthController::class, 'sessionLogout']);
        Route::get('session/user', [AuthController::class, 'me']);
    });
});