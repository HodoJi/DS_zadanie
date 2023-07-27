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

// Logout:
Route::name('logout')->match(['get', 'post'], '/logout', [\App\Http\Controllers\AuthController::class, 'doLogout'])->middleware('auth:sanctum');

// Categories:
Route::group(["middleware" => 'auth:sanctum'], function()
{
    Route::name('categories')->get("/categories", function()
    {
        return view('categories');
    });

    Route::name('products')->get("/products", function()
    {
       return view('products');
    });
});
