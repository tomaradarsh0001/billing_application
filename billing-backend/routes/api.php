<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ConfigurationApiController;
use App\Http\Controllers\Api\BillingDetailApiController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//configuration API
Route::get('/configuration/{id}', [ConfigurationApiController::class, 'fetchConfiguration']);

//Customer Details API
Route::get('customers', [CustomerApiController::class, 'index']);
Route::get('customers/{id}', [CustomerApiController::class, 'show']);
Route::post('customers', [CustomerApiController::class, 'store']);
Route::put('customers/{id}', [CustomerApiController::class, 'update']);
Route::delete('customers/{id}', [CustomerApiController::class, 'destroy']);

//Billing Details API
Route::get('billings', [BillingDetailApiController::class, 'index']);
Route::get('billings/{id}', [BillingDetailApiController::class, 'show']);
Route::post('billings', [BillingDetailApiController::class, 'store']);
Route::put('billings/{id}', [BillingDetailApiController::class, 'update']);
Route::delete('billings/{id}', [BillingDetailApiController::class, 'destroy']);
