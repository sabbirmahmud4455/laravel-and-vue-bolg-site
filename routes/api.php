<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::resource('/dashboard/tag', TagController::class);
Route::resource('/dashboard/category', CategoryController::class);
Route::resource('/dashboard/user', UserController::class);
Route::resource('/dashboard/role', RoleController::class);
// role assigns
Route::put('/dashboard/role_assigns', [RoleController::class, 'role_assigns' ]);
