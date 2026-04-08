<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AnnouncementController;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\RoleController;

use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\ConversationController;


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

Route::post(
    '/messages',
    [MessageController::class, 'store']
);

Route::middleware('auth:sanctum')->group(function () {

    Route::get(
        '/conversations',
        [ConversationController::class, 'index']
    );

    Route::post(
        '/conversations',
        [ConversationController::class, 'store']
    );

});