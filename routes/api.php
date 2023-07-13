<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Login:
Route::name("api/login")->match(['GET', 'POST'], 'login', [\App\Http\Controllers\API\AuthController::class, 'doLogin']);

// Logout:
Route::name('api/logout')->post('logout', [\App\Http\Controllers\API\AuthController::class, 'doLogout'])->middleware('auth:sanctum');
