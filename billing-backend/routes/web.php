<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BillingDetailController;
use App\Http\Controllers\Billing\OccupantDetailController;
use App\Http\Controllers\Billing\HouseDetailController;


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

    Route::get('/users/add', [UserController::class, 'create'])->name('users.create')->middleware('permission:users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store')->middleware('permission:users.create');
});


// Allow superadmin access to manage roles and permissions
Route::middleware(['role:superadmin'])->group(function () {
    //configurations
    Route::get('/configuration', [ConfigurationController::class, 'index'])->name('configuration.index');
    Route::get('/configuration/{id}/view', [ConfigurationController::class, 'view'])->name('configuration.view');
    Route::delete('/configuration/{id}', [ConfigurationController::class, 'destroy'])->name('configuration.destroy');
    Route::get('/configuration/create', [ConfigurationController::class, 'create'])->name('configuration.create');
    Route::post('/configuration/store', [ConfigurationController::class, 'store'])->name('configuration.store');
    Route::get('/configuration/{id}/edit', [ConfigurationController::class, 'edit'])->name('configuration.edit');
    Route::put('/configuration/{id}', [ConfigurationController::class, 'update'])->name('configuration.update');
    Route::get('/configuration/check-app-name', [ConfigurationController::class, 'checkAppName'])->name('configuration.checkAppName');
    Route::get('/check-app-name', [ConfigurationController::class, 'checkAppNameEdit'])->name('configuration.checkAppNameEdit');

    //roles
    Route::get('/roles', [UserController::class, 'manageRoles'])->name('roles.index');
    Route::post('/roles', [UserController::class, 'assignRoles'])->name('roles.assign');
    Route::get('/roles/add', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.delete');
    Route::get('/roles/{role}/permissions', [UserController::class, 'managePermissions'])->name('roles.permissions');
    Route::post('/roles/{role}/permissions/add', [UserController::class, 'addPermission'])->name('roles.permissions.add');
    Route::post('/roles/{role}/permissions/remove', [UserController::class, 'removePermission'])->name('roles.permissions.remove');
    Route::get('roles/check-name-edit', [RoleController::class, 'checkRoleNameEdit'])->name('roles.checkNameEdit');
    Route::get('roles/check-name', [RoleController::class, 'checkRoleName'])->name('roles.checkName');

    //users
    Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware('permission:users.view');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show')->middleware('permission:users.view');
    Route::get('/users/{user}/editrolesandpermissions', [UserController::class, 'perandroles'])->name('users.perandroles')->middleware('permission:users.edit');
    Route::post('/users/{user}/updated', [UserController::class, 'updateperandroles'])->name('users.updateperandroles')->middleware('permission:users.edit');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('permission:users.edit');
    Route::post('/users/{user}', [UserController::class, 'update'])->name('users.update')->middleware('permission:users.edit');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.delete')->middleware('permission:users.delete');
    Route::get('check-email/{email}', [UserController::class, 'checkEmail'])->name('check.email');
    Route::get('/check-email-edit', [UserController::class, 'checkEmailEdit'])->name('users.checkEmailEdit');

    //permissions
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index')->middleware('permission:permissions.view');
    Route::get('permissions/create', [PermissionController::class, 'create'])->name('permissions.create')->middleware('permission:permissions.create');
    Route::post('permissions', [PermissionController::class, 'store'])->name('permissions.store')->middleware('permission:permissions.create');
    Route::get('permissions/{permission}/edit', [PermissionController::class, 'edit'])->name('permissions.edit')->middleware('permission:permissions.edit');
    Route::put('permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update')->middleware('permission:permissions.edit');
    Route::delete('permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy')->middleware('permission:permissions.delete');
    Route::get('permissions/check-name-edit', [PermissionController::class, 'checkPermissionNameEdit'])->name('permissions.checkNameEdit');
    Route::get('permissions/check-name', [PermissionController::class, 'checkPermissionName'])->name('permissions.checkName');

    //Locations Dropdowns
    Route::resource('customers', CustomerController::class);
    Route::get('/states', [CustomerController::class, 'getStates'])->name('get.states');
    Route::get('/cities', [CustomerController::class, 'getCities'])->name('get.cities');

    //occupant section
    Route::get('billing/occupants/create', [OccupantDetailController::class, 'create'])->name('occupants.create');
    Route::get('billing/occupants', [OccupantDetailController::class, 'index'])->name('occupants.index');
    Route::get('billing/mapped/occupants-houses', [OccupantDetailController::class, 'indexMapped'])->name('occupants.indexMapped');
    Route::get('billing/occupants/{occupantDetail}/edit', [OccupantDetailController::class, 'edit'])->name('occupants.edit');
    Route::put('billing/occupants/{occupantDetail}', [OccupantDetailController::class, 'update'])->name('occupants.update');
    Route::get('billing/occupants/{id}', [OccupantDetailController::class, 'show'])->name('occupants.show');
    Route::delete('billing/occupants/{occupantDetail}', [OccupantDetailController::class, 'destroy'])->name('occupants.destroy');
    Route::post('billing/occupants', [OccupantDetailController::class, 'store'])->name('occupants.store');
    
    //house detail
    Route::get('billing/houses/create', [HouseDetailController::class, 'create'])->name('houses.create');
    Route::post('billing/houses', [HouseDetailController::class, 'store'])->name('houses.store');
    Route::get('billing/houses/{houseDetail}/edit', [HouseDetailController::class, 'edit'])->name('houses.edit');
    Route::put('billing/houses/{houseDetail}', [HouseDetailController::class, 'update'])->name('houses.update');
    Route::delete('billing/houses/{houseDetail}', [HouseDetailController::class, 'destroy'])->name('houses.destroy');
    Route::get('billing/houses', [HouseDetailController::class, 'index'])->name('houses.index');

    //billing details
    Route::post('billing-details', [BillingDetailController::class, 'store'])->name('billing_details.store');
    Route::get('billing-details/{billing_detail}', [BillingDetailController::class, 'show'])->name('billing_details.show');
    Route::get('billing-details/{billing_detail}/edit', [BillingDetailController::class, 'edit'])->name('billing_details.edit');
    Route::put('billing-details/{billing_detail}', [BillingDetailController::class, 'update'])->name('billing_details.update');
    Route::get('billing-details', [BillingDetailController::class, 'index'])->name('billing_details.index');
    Route::delete('billing-details/{billing_detail}', [BillingDetailController::class, 'destroy'])->name('billing_details.destroy');
    Route::get('billing_details/create', [BillingDetailController::class, 'create'])->name('billing_details.create');
    Route::get('/api/fonts', [ConfigurationController::class, 'getFonts'])->name('fonts.api');


});
require __DIR__ . '/auth.php';
