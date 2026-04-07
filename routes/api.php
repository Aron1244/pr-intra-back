<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::middleware(['api', 'auth:sanctum'])->group(function (): void {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('users', UserController::class);
});

Route::middleware(['api', 'auth:sanctum'])->group(function (): void {
    Route::apiResource('roles', \App\Http\Controllers\Api\RoleController::class);
});

Route::middleware(['api', 'auth:sanctum'])->group(function (): void {
    Route::apiResource('documents', \App\Http\Controllers\Api\DocumentController::class);
});

