<?php

use App\Http\Controllers\LocaleController;
use App\Domains\V1\Swagger\Http\Controllers\Frontend\YamlFrontendController;

/*
 * Global Routes
 *
 * Routes that are used between both frontend and backend.
 */

// Switch between the included languages
Route::get('lang/{lang}', [LocaleController::class, 'change'])->name('locale.change');

/*
 * Frontend Routes
 */
Route::name('frontend.')->group(function () {
    includeRouteFiles(__DIR__.'/frontend/');
});

/*
 * Backend Routes
 *
 * These routes can only be accessed by users with type `admin`
 */
Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    includeRouteFiles(__DIR__.'/backend/');
});

Route::get('test-form/swagger.json', [YamlFrontendController::class, 'getYaml']);
