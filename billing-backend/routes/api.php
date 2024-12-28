<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ConfigurationApiController;
use App\Http\Controllers\Api\CustomerApiController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/configuration/{id}', [ConfigurationApiController::class, 'fetchConfiguration']);


Route::get('customers', [CustomerApiController::class, 'index']);
Route::get('customers/{id}', [CustomerApiController::class, 'show']);
Route::post('customers', [CustomerApiController::class, 'store']);
Route::put('customers/{id}', [CustomerApiController::class, 'update']);
Route::delete('customers/{id}', [CustomerApiController::class, 'destroy']);
