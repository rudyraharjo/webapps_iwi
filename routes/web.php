<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VillageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes([
    'verify' => true,
    'register' => false
]);

Route::get('/app', function () {
    return redirect('/app/dashboard');
});

Route::group(['prefix' => 'app'], function () {

    Route::get('lang/{locale}', function ($locale) {
        app()->setLocale($locale);
        session()->put('locale', $locale);
        return redirect()->back();
    });

    Route::group(['middleware' => ['auth', 'verified']], function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Route::group(['middleware' => ['role:root|administrator|owner|board-of-director']], function () {

            // Route::group(['prefix' => 'company'], function () {
            //     Route::get('/', [CompanyController::class, 'index'])->name('company.index')->middleware('permission:read-company');
            //     Route::get('/create', [CompanyController::class, 'create'])->name('company.create')->middleware('permission:create-company');
            //     Route::get('/update', [CompanyController::class, 'update'])->name('company.update')->middleware('permission:update-company');
            //     Route::get('/delete', [CompanyController::class, 'delete'])->name('company.delete')->middleware('permission:delete-company');
            // });

            // configuration
            // Route::group(['prefix' => 'configuration'], function () {

            //     Route::group(['prefix' => 'area'], function () {

            //         Route::group(['prefix' => 'provinces'], function () {
            //             Route::get('/', [ProvinceController::class, 'index'])->name('province.index')->middleware('permission:create-province');
            //             Route::post('/store', [ProvinceController::class, 'store'])->name('province.store')->middleware('permission:create-province');
            //             Route::post('/update', [ProvinceController::class, 'update'])->name('province.update')->middleware('permission:update-province');
            //             Route::post('/delete', [ProvinceController::class, 'delete'])->name('province.delete')->middleware('permission:delete-province');
            //         });

            //         Route::group(['prefix' => 'cities'], function () {
            //             Route::get('/', [CityController::class, 'index'])->name('city.index')->middleware('permission:create-city');
            //             Route::post('/store', [CityController::class, 'store'])->name('city.store')->middleware('permission:create-city');
            //             Route::post('/update', [CityController::class, 'update'])->name('city.update')->middleware('permission:update-city');
            //             Route::post('/delete', [CityController::class, 'delete'])->name('city.delete')->middleware('permission:delete-city');
            //         });

            //         Route::group(['prefix' => 'districts'], function () {
            //             Route::get('/', [DistrictController::class, 'index'])->name('district.index')->middleware('permission:create-district');
            //             Route::post('/store', [DistrictController::class, 'store'])->name('district.store')->middleware('permission:create-district');
            //             Route::post('/update', [DistrictController::class, 'update'])->name('district.update')->middleware('permission:update-district');
            //             Route::post('/delete', [DistrictController::class, 'delete'])->name('district.delete')->middleware('permission:delete-district');
            //         });

            //         Route::group(['prefix' => 'villages'], function () {
            //             Route::get('/', [VillageController::class, 'index'])->name('village.index')->middleware('permission:create-village');
            //             Route::post('/store', [VillageController::class, 'store'])->name('village.store')->middleware('permission:create-village');
            //             Route::post('/update', [VillageController::class, 'update'])->name('village.update')->middleware('permission:update-village');
            //             Route::post('/delete', [VillageController::class, 'delete'])->name('village.delete')->middleware('permission:delete-village');
            //         });
            //     });

            //     Route::group(['prefix' => 'manage'], function () {

            //         Route::group(['prefix' => 'teams'], function () {
            //             Route::get('/', [TeamController::class, 'index'])->name('team.index')->middleware('permission:read-team');
            //             Route::post('/store', [TeamController::class, 'store'])->name('team.store')->middleware('permission:create-team');
            //             Route::post('/update', [TeamController::class, 'update'])->name('team.update')->middleware('permission:update-team');
            //             Route::post('/delete', [TeamController::class, 'delete'])->name('team.delete')->middleware('permission:delete-team');
            //         });

            //         Route::group(['prefix' => 'users'], function () {
            //             Route::get('/', [UserController::class, 'index'])->name('user.index')->middleware('permission:read-user');
            //             Route::post('/store', [UserController::class, 'store'])->name('user.store')->middleware('permission:create-user');
            //             Route::post('/update', [UserController::class, 'update'])->name('user.update')->middleware('permission:update-user');
            //             Route::post('/delete', [UserController::class, 'delete'])->name('user.delete')->middleware('permission:delete-user');
            //         });

            //         Route::group(['prefix' => 'roles'], function () {
            //             Route::get('/', [RoleController::class, 'index'])->name('role.index')->middleware('permission:read-role');
            //             Route::get('/create', [RoleController::class, 'create'])->name('role.create')->middleware('permission:create-role');
            //             Route::post('/store', [RoleController::class, 'store'])->name('role.store')->middleware('permission:create-role');
            //             Route::post('/update', [RoleController::class, 'update'])->name('role.update')->middleware('permission:update-role');
            //             Route::post('/delete', [RoleController::class, 'delete'])->name('role.delete')->middleware('permission:update-role');
            //         });

            //         Route::group(['prefix' => 'permissions'], function () {
            //             Route::get('/', [PermissionController::class, 'index'])->name('permission.index')->middleware('permission:read-permission');
            //             Route::get('/create', [PermissionController::class, 'create'])->name('permission.create')->middleware('permission:create-permission');
            //             Route::post('/store', [PermissionController::class, 'store'])->name('permission.store')->middleware('permission:create-permission');
            //             Route::post('/update', [PermissionController::class, 'update'])->name('permission.update')->middleware('permission:update-permission');
            //             Route::post('/delete', [PermissionController::class, 'delete'])->name('permission.delete')->middleware('permission:delete-permission');
            //         });
            //     });
            // });
        // });
    });
});
