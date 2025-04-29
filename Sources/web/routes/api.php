<?php

use Illuminate\Support\Facades\Route;
use App\Domains\V1\Auth\Http\Controllers\Api\AuthApiController;
use App\Domains\V1\Auth\Http\Controllers\Api\UserApiController;
use App\Domains\V1\News\Http\Controllers\Api\PostApiController;
use App\Domains\V1\Token\Http\Controllers\Api\ApiKeyApiController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Domains\V1\Swagger\Http\Controllers\Api\YamlApiController;

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

Route::prefix('v1')->group(function () {

    Route::get('test-form/swagger.json', [YamlApiController::class, 'getYaml']);

    Route::prefix('auth')->controller(AuthApiController::class)->group(function () {
        // Authentication routes
        Route::post('login', 'login')->name('auth.login');
        Route::post('register', 'register')->name('auth.register');
        Route::post('logout', 'logout')->name('auth.logout');
        Route::post('refresh', 'refresh')->name('auth.refresh');
    });

    Route::middleware('auth:api')->group(function () {
        // API key routes
        Route::middleware('permission:admin.access.api.key.create')
            ->post('api-key', [ApiKeyApiController::class, 'store'])
            ->name('api-key.store');

        // User routes
        Route::controller(UserController::class)
            ->name('user.')
            ->prefix('users')
            ->group(function () {
                Route::middleware('permission:admin.access.user.list|admin.access.user.deactivate|admin.access.user.reactivate|admin.access.user.impersonate')
                    ->get('/', 'index')->name('list');
                
                Route::middleware('permission:admin.access.user.create')
                    ->post('/', 'store')->name('store');
            });

        // Role permission routes
        Route::controller(RoleController::class)
            ->name('role.')
            ->prefix('roles')
            ->group(function () {
                Route::middleware('permission:admin.access.role.view|admin.access.role.create')
                    ->get('/', 'index')->name('list');
                Route::middleware('permission:admin.access.role.create')
                    ->post('/', 'store')->name('store');
                Route::middleware('permission:admin.access.role.view')
                    ->get('/{id}', 'show')->name('show');
            });

        // Permission routes
        Route::controller(PermissionController::class)
            ->name('permission.')
            ->prefix('permissions')
            ->group(function () {
                Route::middleware('permission:admin.access.permission.view|admin.access.permission.create')
                    ->get('/', 'index')->name('list');
                Route::middleware('permission:admin.access.permission.create')
                    ->post('/', 'store')->name('store');
            });

        // News Article routes
        Route::middleware('permission:admin.access.post.read|admin.access.post.create')
            ->get('posts', [PostController::class, 'index'])
            ->name('post.index');

        Route::middleware('permission:admin.access.post.create')
            ->post('posts', [PostController::class, 'store'])
            ->name('post.store');

        Route::middleware('permission:admin.access.post.delete')
            ->delete('posts/{id}', [PostController::class, 'destroy'])
            ->name('post.delete');

        // News sync routes
        Route::middleware(['throttle:5,1', 'permission:admin.access.post.create'])
        ->post('/sync-news', [PostApiController::class, 'sync'])
        ->name('post.sync');

        Route::middleware('permission:admin.access.post.create')
            ->post('cli-sync-news', [PostApiController::class, 'syncNews'])
            ->name('post.cli.sync');
    });
});