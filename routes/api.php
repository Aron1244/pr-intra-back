<?php

use App\Http\Controllers\Api\AnnouncementController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\ConversationController;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserRoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);

Route::middleware(['api', 'auth:sanctum'])->group(function (): void {
    Route::get('me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('users', UserController::class);
    Route::get('users/{user}/roles', [UserRoleController::class, 'index']);
    Route::put('users/{user}/roles', [UserRoleController::class, 'update']);
});

Route::middleware(['api', 'auth:sanctum'])->group(function (): void {
    Route::apiResource('roles', RoleController::class);
});

Route::middleware(['api', 'auth:sanctum'])->group(function (): void {
    Route::apiResource('documents', DocumentController::class);
});

Route::middleware(['api', 'auth:sanctum'])->group(function (): void {
    Route::apiResource('announcements', AnnouncementController::class);
    Route::post('announcements/{announcement}/comments', [CommentController::class, 'store']);
});

Route::middleware('auth:sanctum')->group(function (): void {
    Route::get(
        '/conversations/{conversation}/messages',
        [MessageController::class, 'index']
    );

    Route::post(
        '/messages',
        [MessageController::class, 'store']
    );

    Route::middleware('admin')->group(function (): void {
        Route::delete(
            '/messages/{message}',
            [MessageController::class, 'destroy']
        );

        Route::delete(
            '/conversations/{conversation}',
            [ConversationController::class, 'destroy']
        );
    });
});

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
