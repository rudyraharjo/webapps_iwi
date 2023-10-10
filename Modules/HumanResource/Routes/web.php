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
Route::group(['prefix' => 'app', 'middleware' => ['auth', 'verified', 'role:root|administrator|owner|board-of-director|human-resource']], function () {
    Route::prefix('humanresource')->group(function () {
        Route::group(['prefix' => 'employee'], function () {
            Route::get('/', 'EmployeeController@index')->name('employee.index');
            Route::post('/store', 'EmployeeController@store')->name('employee.store');
            Route::post('/update', 'EmployeeController@update')->name('employee.update');
            Route::post('/delete', 'EmployeeController@delete')->name('employee.delete');
        });
    });
});
