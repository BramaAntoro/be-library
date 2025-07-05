<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MemberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login'])->middleware('AlreadyLoggedIn');

Route::get('/categories', [CategoryController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

    Route::middleware('role:admin')->group(function () {

        Route::post('/member', [MemberController::class, 'store']);
        Route::get('/members', [MemberController::class, 'index']);
        Route::put('/member/{id}', [MemberController::class, 'update']);
        Route::delete('/member/{id}', [MemberController::class, 'destroy']);

        Route::post('/author', [AuthorController::class, 'store']);
        Route::get('/authors', [AuthorController::class, 'index']);
        Route::put('/author/{id}', [AuthorController::class, 'update']);
        Route::delete('/author/{id}', [AuthorController::class, 'destroy']);

        Route::post('/category', [CategoryController::class, 'store']);
        Route::put('/category/{id}', [CategoryController::class, 'update']);
        Route::delete('/category/{id}', [CategoryController::class, 'destroy']);

    });

});
