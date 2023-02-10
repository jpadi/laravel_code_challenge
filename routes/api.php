<?php

use App\Http\Controllers\API\Dashboard\DashboardStatsController;
use App\Http\Controllers\API\Domains\DomainSearchController;
use App\Http\Controllers\API\Domains\DomainCreateController;
use App\Http\Controllers\API\Domains\DomainUpdateController;
use App\Http\Controllers\API\Domains\DomainDeleteController;
use App\Http\Controllers\API\Settings\SettingGetController;
use App\Http\Controllers\API\Settings\SettingUpdateController;
use App\Http\Controllers\API\Shorter\CreateUrlController;
use \App\Http\Controllers\API\Shorter\SearchUrlController;
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
// dashboard module
Route::get('/dashboard/stats', [DashboardStatsController::class, "stats"]);

// domain module
Route::get('/domains', [DomainSearchController::class, "index"]);
Route::post('/domains', [DomainCreateController::class, "create"]);
Route::put('/domains/{id}', [DomainUpdateController::class, "update"]);
Route::delete('/domains/{id}', [DomainDeleteController::class, "delete"]);

// setting module
Route::get('/settings/{id}', [SettingGetController::class, "get"]);
Route::put('/settings/{id}', [SettingUpdateController::class, "update"]);

// shorter module
Route::get('/url', [SearchUrlController::class, "search"]);
Route::post('/url', [CreateUrlController::class, "create"]);

