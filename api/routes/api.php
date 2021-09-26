<?php

use App\Http\Controllers\Api\ManagementController;
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
Route::prefix('v1/manage')->group(function(){
    Route::get('resources/{resource}/pdf-download', [ManagementController::class, 'pdfDownload']);
    Route::apiResource('resources', ManagementController::class);
});
