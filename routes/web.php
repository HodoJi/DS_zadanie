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

// Home:
Route::name('home')->get('/', function() {
    if (!Auth::check()) // not logged in
        return redirect(route('login'));
    else // logged in
        return view('home');
});

// Login:
Route::name('login')->get('/login', function() {
    if (Auth::check())
        return redirect(route('home'));
    else
        return view('login');
});
