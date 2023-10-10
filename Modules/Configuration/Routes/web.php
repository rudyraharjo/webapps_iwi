<?php

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

Route::group(['prefix' => 'app', 'middleware' => ['auth', 'verified', 'role:root|administrator|owner|board-of-director']], function () {
    Route::prefix('configuration')->group(function () {
        Route::group(['prefix' => 'bank'], function () {
            Route::get('/', 'BankController@index')->name('bank.index');
            Route::post('/store', 'BankController@store')->name('bank.store');
            Route::post('/update', 'BankController@update')->name('bank.update');
            Route::post('/delete', 'BankController@delete')->name('bank.delete');
        });

        Route::group(['prefix' => 'identitycard'], function () {
            Route::get('/', 'IdentityCardController@index')->name('identitycard.index');
            Route::post('/store', 'IdentityCardController@store')->name('identitycard.store');
            Route::post('/update', 'IdentityCardController@update')->name('identitycard.update');
            Route::post('/delete', 'IdentityCardController@delete')->name('identitycard.delete');
        });

        Route::group(['prefix' => 'bussines-partner'], function () {
            Route::group(['prefix' => 'groups'], function () {
                Route::get('/', 'BusinessPartnerGroupController@index')->name('bp_group.index');
                Route::post('/store', 'BusinessPartnerGroupController@store')->name('bp_group.store');
                Route::post('/update', 'BusinessPartnerGroupController@update')->name('bp_group.update');
                Route::post('/delete', 'BusinessPartnerGroupController@delete')->name('bp_group.delete');
            });
            Route::group(['prefix' => 'categories'], function () {
                Route::get('/', 'BussinesPartnerCategoryController@index')->name('bp_category.index');
                Route::post('/store', 'BussinesPartnerCategoryController@store')->name('bp_category.store');
                Route::post('/update', 'BussinesPartnerCategoryController@update')->name('bp_category.update');
                Route::post('/delete', 'BussinesPartnerCategoryController@delete')->name('bp_category.delete');
            });
            Route::group(['prefix' => 'designation'], function () {
                Route::get('/', 'BussinesPartnerDesignationController@index')->name('bp_designation.index');
                Route::post('/store', 'BussinesPartnerDesignationController@store')->name('bp_designation.store');
                Route::post('/update', 'BussinesPartnerDesignationController@update')->name('bp_designation.update');
                Route::post('/delete', 'BussinesPartnerDesignationController@delete')->name('bp_designation.delete');
            });
        });
        Route::group(['prefix' => 'area'], function () {
            Route::group(['prefix' => 'provinces'], function () {
                Route::get('/', 'ProvinceController@index')->name('province.index')->middleware('permission:read-province');
                Route::post('/store', 'ProvinceController@store')->name('province.store')->middleware('permission:create-province');
                Route::post('/update', 'ProvinceController@update')->name('province.update')->middleware('permission:update-province');
                Route::post('/delete', 'ProvinceController@delete')->name('province.delete')->middleware('permission:delete-province');
            });
            Route::group(['prefix' => 'cities'], function () {
                Route::get('/', 'CityController@index')->name('city.index')->middleware('permission:read-city');
                Route::post('/store', 'CityController@store')->name('city.store')->middleware('permission:create-city');
                Route::post('/update', 'CityController@update')->name('city.update')->middleware('permission:update-city');
                Route::post('/delete', 'CityController@delete')->name('city.delete')->middleware('permission:delete-city');
            });
            Route::group(['prefix' => 'districts'], function () {
                Route::get('/', 'DistrictController@index')->name('district.index')->middleware('permission:read-district');
                Route::post('/store', 'DistrictController@store')->name('district.store')->middleware('permission:create-district');
                Route::post('/update', 'DistrictController@update')->name('district.update')->middleware('permission:update-district');
                Route::post('/delete', 'DistrictController@delete')->name('district.delete')->middleware('permission:delete-district');
            });
            Route::group(['prefix' => 'villages'], function () {
                Route::get('/', 'VillageController@index')->name('village.index')->middleware('permission:read-village');
                Route::post('/store', 'VillageController@store')->name('village.store')->middleware('permission:create-village');
                Route::post('/update', 'VillageController@update')->name('village.update')->middleware('permission:update-village');
                Route::post('/delete', 'VillageController@delete')->name('village.delete')->middleware('permission:delete-village');
            });
        });

        Route::prefix('manage')->group(function () {

            Route::group(['prefix' => 'teams'], function () {
                Route::get('/', 'TeamController@index')->name('team.index')->middleware('permission:read-team');
                Route::post('/store', 'TeamController@store')->name('team.store')->middleware('permission:create-team');
                Route::post('/update', 'TeamController@update')->name('team.update')->middleware('permission:update-team');
                Route::post('/delete', 'TeamController@delete')->name('team.delete')->middleware('permission:delete-team');
            });

            Route::group(['prefix' => 'users'], function () {
                Route::get('/', 'UserController@index')->name('user.index')->middleware('permission:read-user');
                Route::post('/store', 'UserController@store')->name('user.store')->middleware('permission:create-user');
                Route::post('/update', 'UserController@update')->name('user.update')->middleware('permission:update-user');
                Route::post('/delete', 'UserController@delete')->name('user.delete')->middleware('permission:delete-user');
            });

            Route::group(['prefix' => 'roles'], function () {
                Route::get('/', 'RoleController@index')->name('role.index')->middleware('permission:read-role');
                Route::post('/store', 'RoleController@store')->name('role.store')->middleware('permission:create-role');
                Route::post('/update', 'RoleController@update')->name('role.update')->middleware('permission:update-role');
                Route::post('/delete', 'RoleController@delete')->name('role.delete')->middleware('permission:delete-role');
            });

            Route::group(['prefix' => 'permissions'], function () {
                Route::get('/', 'PermissionController@index')->name('permission.index')->middleware('permission:read-permission');
                Route::post('/store', 'PermissionController@store')->name('permission.store')->middleware('permission:create-permission');
                Route::post('/update', 'PermissionController@update')->name('permission.update')->middleware('permission:update-permission');
                Route::post('/delete', 'PermissionController@delete')->name('permission.delete')->middleware('permission:delete-permission');
            });
        });
    });
});
