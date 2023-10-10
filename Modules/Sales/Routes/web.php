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

Route::group(['prefix' => 'app', 'middleware' => ['auth', 'verified', 'role:root|administrator|owner|board-of-director|sales']], function () {
    Route::prefix('business-partner')->group(function () {
        Route::get('/', 'BusinessPartnerController@index')->name('business_partner.index');
        Route::get('/create', 'BusinessPartnerController@create')->name('business_partner.create');
        Route::post('/store', 'BusinessPartnerController@store')->name('business_partner.store');
        Route::get('/edit/{id}', 'BusinessPartnerController@edit')->name('business_partner.edit');
        Route::post('/update/{id}', 'BusinessPartnerController@update')->name('business_partner.update');
        Route::post('/delete', 'BusinessPartnerController@delete')->name('business_partner.delete');
    });
});
