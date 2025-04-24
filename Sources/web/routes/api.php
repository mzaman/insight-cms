<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Domains\V1\Auth\Http\Controllers\Api\AuthApiController;
use App\Domains\V1\News\Http\Controllers\Api\PostApiController;
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


Route::prefix('v1')->group(function () {
    
    Route::prefix('auth')->controller(AuthApiController::class)->group(function () {
        // Route::post('login', 'login')->name('auth.login');
        Route::post('register', 'register')->name('auth.register');
        Route::post('logout', 'logout')->name('auth.logout');
        Route::post('refresh', 'refresh')->name('auth.refresh');
    });

    Route::controller(PermissionController::class)
        ->name('permission.')
        ->prefix('permissions')
        ->group(function () {
            Route::get('/', 'index')->name('list');
            Route::post('/', 'store')->name('store');
        });

    Route::controller(RoleController::class)
        ->name('role.')
        ->prefix('roles')
        ->group(function () {
            Route::get('/', 'index')->name('list');
            Route::post('/', 'store')->name('store');
            Route::get('/{id}', 'show')->name('show');
        });

    Route::controller(UserController::class)
        ->name('user.')
        ->prefix('users')
        ->group(function () {
            Route::get('/', 'index')->name('list');
        });

    Route::middleware('auth:api')->group(function () {
        Route::middleware('post.access:read')
            ->get('posts', [PostController::class, 'index'])
            ->name('post.index');

        Route::middleware('post.access:create')
            ->post('posts', [PostController::class, 'store'])
            ->name('post.store');

        Route::middleware(['throttle:5,1', 'post.access:create'])
            ->post('/sync-news', [PostApiController::class, 'sync'])
            ->name('post.sync');

        Route::post('cli-sync-news', [PostApiController::class, 'syncNews']);

        Route::middleware('post.access:delete')
            ->delete('posts/{id}', [PostController::class, 'destroy'])
            ->name('post.delete');
    });
});