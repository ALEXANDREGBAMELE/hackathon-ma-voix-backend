<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Api\Admin\AdminController;
use Illuminate\Http\Request;
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

//authentification

Route::controller(AuthController::class)->group(function () {
    Route::prefix('/auth')->group(function () {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
        Route::post('/logout', 'logout');
    });
});


Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::prefix('/admin')->group(function () {
        Route::get('/users', [AdminController::class, 'getAllUsers']);
        Route::get('/users/{id}', [AdminController::class, 'getUser']);
        Route::delete('/users/{id}', [AdminController::class, 'deleteUser']);
    });
});



