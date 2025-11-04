<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

// صفحة واجهة بسيطة لعرض المهام
Route::get('/tasks', function () {
    return view('tasks');
});

// مسارات جلسات Sanctum عبر الكوكيز تحت مجموعة web لبدء الجلسة
Route::prefix('api')->middleware(['web'])->group(function () {
    Route::post('session/login', [AuthController::class, 'sessionLogin']);
    Route::post('session/logout', [AuthController::class, 'sessionLogout']);
    Route::get('session/user', [AuthController::class, 'me']);
});

// مسارات المهام تحت web + auth:sanctum لضمان عمل الكوكي للجلسة
Route::prefix('api')->middleware(['web', 'auth:sanctum'])->group(function () {
    Route::get('tasks', [\App\Http\Controllers\TaskController::class, 'index']);
    Route::post('tasks', [\App\Http\Controllers\TaskController::class, 'store']);
    Route::put('tasks/{task}', [\App\Http\Controllers\TaskController::class, 'update']);
    Route::patch('tasks/{task}/toggle', [\App\Http\Controllers\TaskController::class, 'toggle']);
    Route::delete('tasks/{task}', [\App\Http\Controllers\TaskController::class, 'destroy']);
});