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

Route::name('api/')->group(function() {
    // Categories:
    Route::name('getCategories')->get('get-categories', [\App\Http\Controllers\API\CategoryController::class, "getCategories"]);
    Route::name('getCategory')->get('get-category/{category_identifier}', [\App\Http\Controllers\API\CategoryController::class, "getCategoryByIdOrSlug"]);
    // Products:
    Route::name('getProducts')->get('get-products', [\App\Http\Controllers\API\ProductController::class, "getProducts"]);
    Route::name('getProduct')->get('get-product/{id}', [\App\Http\Controllers\API\ProductController::class, "getProductById"]);
    Route::name('getProductsByCategory')->get('get-category/{category_identifier}/products', [\App\Http\Controllers\API\ProductController::class, "getProductsByCategoryIdOrSlug"]);
});
