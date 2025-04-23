<?php

use Illuminate\Support\Facades\Route;

use App\Domains\V1\Yaml\Http\Controllers\Api\YamlController;

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

Route::get('/yaml-content', [YamlController::class, 'getYamlContent']);
Route::get('/', function () {
    return view('welcome');
});
