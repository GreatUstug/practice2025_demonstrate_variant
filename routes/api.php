<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistrController;
use App\Http\Controllers\AllPostsController;
use App\Http\Controllers\AllMyPostsController;

Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/auth/registr', [RegistrController::class, 'registr']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/posts/create', [PostController::class, 'store']);
    Route::get('/posts/showall', [AllPostsController::class, 'showall']);
    Route::get('/posts/showallmy', [AllMyPostsController::class, 'showallmy']);
});

