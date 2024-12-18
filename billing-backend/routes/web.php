<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    //configurations
    Route::get('/configuration', [ConfigurationController::class, 'index'])->name('configuration.index');
    Route::get('/configuration/{id}/view', [ConfigurationController::class, 'view'])->name('configuration.view');
    Route::delete('/configuration/{id}', [ConfigurationController::class, 'destroy'])->name('configuration.destroy');
    Route::get('/configuration/create', [ConfigurationController::class, 'create'])->name('configuration.create');
    Route::post('/configuration/store', [ConfigurationController::class, 'store'])->name('configuration.store');
    Route::get('/configuration/{id}/edit', [ConfigurationController::class, 'edit'])->name('configuration.edit');
    Route::put('/configuration/{id}', [ConfigurationController::class, 'update'])->name('configuration.update');

    // RBAC: Roles, Permissions, Users
    Route::middleware('role:Superadmin')->group(function () {
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);
    });

    Route::middleware('role:Admin')->group(function () {
        Route::resource('users', UserController::class);
    });
});

require __DIR__ . '/auth.php';
