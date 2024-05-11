<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:api');
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('user', [UserController::class, 'me']);
    Route::get('post/my', [PostController::class, 'my']);
    Route::apiResource('post', PostController::class);

    Route::group(['prefix' => 'admin', 'middleware' => 'role:admin'], function () {
        Route::apiResource('user', AdminController::class);
    });
});

