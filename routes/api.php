<?php

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

Route::apiResource('companies', \App\Http\Controllers\CompainesController::class);
Route::apiResource('companypackages', \App\Http\Controllers\CompanyPackageController::class);
Route::post('company/check-company-package', [\App\Http\Controllers\CompainesController::class, 'check_company_package']);
