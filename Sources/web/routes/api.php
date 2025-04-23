<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::controller(PermissionController::class)->name('permission.')->prefix('permission')->group(function(){
    Route::get('/', 'index')->name('list');
    Route::post('/', 'store')->name('store');
});

Route::controller(RoleController::class)->name('role.')->prefix('role')->group(function(){
    Route::get('/', 'index')->name('list');
    Route::post('/', 'store')->name('store');
    Route::get('/{id}', 'show')->name('show');
});

Route::controller(UserController::class)->name('user.')->prefix('user')->group(function(){
    Route::get('/', 'index')->name('list');
});

Route::middleware('auth:api')->group(function(){
    Route::middleware('post.access:read')->get('post', [PostController::class, 'index'])->name('post.index');
    Route::middleware('post.access:create')->post('post', [PostController::class, 'store'])->name('post.store');
    Route::middleware('post.access:delete')->delete('post/{id}', [PostController::class, 'destroy'])->name('post.delete');
});