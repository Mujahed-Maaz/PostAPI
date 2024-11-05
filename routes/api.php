<?php

use App\Http\Controllers\api\V1\CommentController;
use App\Http\Controllers\api\V1\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\api\V1', 'middleware' => 'auth:sanctum'], function () {
    Route::apiResource('posts', PostController::class);
    Route::apiResource('comments', CommentController::class);
    Route::delete('posts/force-delete/{id}', [PostController::class, 'forceDelete']);
    Route::put('posts/restore/{id}', [PostController::class, 'restore']);
    Route::delete('comments/force-delete/{id}', [CommentController::class, 'forceDelete']);
    Route::put('comments/restore/{id}', [CommentController::class, 'restore']);
})->middleware('auth:sanctum');
