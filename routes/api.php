<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ApartmentController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function () {
    Route::post('auth/login', 'login');
    Route::post('auth/decrypt', 'decrypt');
});

Route::get('/test', function () {
    return 'prijavljen si';
})->middleware('apiToken');

Route::apiResource('categories', CategoryController::class);
Route::apiResource('apartments', ApartmentController::class);
Route::controller(ApartmentController::class)->group(function () {
    Route::post('apartments/{apartment}/rating', 'rating')->middleware('apiToken');
    Route::post('apartments/{apartment}/subscribe', 'subscribe')->middleware('apiToken');
});