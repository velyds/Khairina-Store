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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('register/check', [App\Http\Controllers\Auth\RegisterController::class, 'check'])->name('api-register-check');
Route::get('provinces', [App\Http\Controllers\API\LocationController::class, 'provinces'])->name('api-provinces');
Route::get('cities/{provinces_id}', [App\Http\Controllers\API\LocationController::class, 'cities'])->name('api-cities');
Route::post('ongkir', [App\Http\Controllers\API\LocationController::class, 'getOngkir']);
// gua tau keknya