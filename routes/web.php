<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'admin'])->group(function () {
    // Route::view('home', 'home')->name('home');
    Route::get('/dashboard/{any}', function(){
        return view('backend.home');
    })->where('any', '.*')->name('dashboard');
    
});
Route::middleware(['guest'])->group(function () {
    
    Route::view('/login', 'login')->name('login_page');
    
});



