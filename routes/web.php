<?php

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

Route::get('/', [\App\Http\Controllers\Web\SpaController::class, "render"]);

// render SpaController when is not an api call to avoid 404
Route::get('/{any}', [\App\Http\Controllers\Web\SpaController::class, "render"])->where('any', '^(?!api).*$');
