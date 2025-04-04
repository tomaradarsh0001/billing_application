<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ConfigurationApiController;
use App\Http\Controllers\Api\BillingDetailApiController;
use App\Http\Controllers\Api\CustomerApiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HouseOccupantDetailApiController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

//configuration API
Route::get('/configuration/{id}', [ConfigurationApiController::class, 'fetchConfiguration']);

//Customer Details API
Route::get('customers', [CustomerApiController::class, 'index']);
Route::get('customers/{id}', [CustomerApiController::class, 'show']);
Route::post('customers', [CustomerApiController::class, 'store']);
Route::put('customers/{id}', [CustomerApiController::class, 'update']);
Route::delete('customers/{id}', [CustomerApiController::class, 'destroy']);

//Billing Details API
Route::prefix('billing-details')->group(function () {
    Route::get('/', [BillingDetailApiController::class, 'index']); // List all billing details  ***working
    Route::post('/', [BillingDetailApiController::class, 'store']); // Create a new billing detail   ***working
    Route::get('{id}', [BillingDetailApiController::class, 'show']); // Get a single billing detail  ***working
    Route::put('{id}', [BillingDetailApiController::class, 'update']); // Update billing detail   ***working
    Route::delete('{id}', [BillingDetailApiController::class, 'destroy']); // Delete billing detail ***working
});


//Occupants and Alloted House Details API
Route::prefix('billing')->group(function () {
    Route::get('/occupants', [HouseOccupantDetailApiController::class, 'index']);
    Route::post('/occupants', [HouseOccupantDetailApiController::class, 'store']);
    Route::get('/occupants/{id}', [HouseOccupantDetailApiController::class, 'show']);
    Route::put('/occupants/{id}', [HouseOccupantDetailApiController::class, 'update']);
    Route::delete('/occupants/{id}', [HouseOccupantDetailApiController::class, 'destroy']);
});
