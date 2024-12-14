<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ConfigurationApiController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/configuration/{id}', [ConfigurationApiController::class, 'fetchConfiguration']);
