<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home (Dashboard):
Route::name('home')->get('/', function() {
    if (!Auth::check()) // not logged in
    {
        return redirect(route('login'));
    }
    else // logged in
    {
        return view('home');
    }
});

// Login:
Route::name('login')->get('/login', function() {
    if (Auth::check())
    {
        return redirect(route('home'));
    }
    else
    {
        return view('login');
    }
});
Route::name('login.post')->post('/login', [\App\Http\Controllers\AuthController::class, 'doLogin']);

// Only for logged in:
Route::group(["middleware" => 'auth:sanctum'], function()
{
    // Logout:
    Route::name('logout')->match(['get', 'post'], '/logout', [\App\Http\Controllers\AuthController::class, 'doLogout']);

    // Categories:
    Route::name('categories')->get("/categories", [\App\Http\Controllers\API\CategoryController::class, "getCategoriesForView"]);
    Route::name("delete-category")->match(['delete', 'get'], "/delete-category", [\App\Http\Controllers\API\CategoryController::class, "deleteCategory"]);
    // Categories - Edit:
    Route::name('edit-category')->get("/edit-category/{identifier}", [\App\Http\Controllers\CategoryEditController::class, "editCategory"]);
    Route::name('edit-category-save')->post("/edit-category", [\App\Http\Controllers\CategoryEditController::class, "editCategorySave"]);

    // Products:
    Route::name('products')->get("/products", [\App\Http\Controllers\API\ProductController::class, "getProductsForView"]);
    Route::name("delete-product")->match(['delete', 'get'], "/delete-product", [\App\Http\Controllers\API\ProductController::class, "deleteProduct"]);
    Route::name("products-in-category")->get("/categories/{category_id}/products", [\App\Http\Controllers\API\ProductController::class, "getProductsForViewByCategoryId"]);
    // Products - Edit:
    Route::name('edit-product')->get("/edit-product/{identifier}", [\App\Http\Controllers\ProductEditController::class, "editProduct"]);
    Route::name('edit-product-save')->post("/edit-product", [\App\Http\Controllers\ProductEditController::class, "editProductSave"]);
});
