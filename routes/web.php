<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'LoginController@index')->name('auth.index');
Route::post('authentication', 'LoginController@authentication')->name('auth.login');

Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    Route::group([
        'as' => 'profil-irigasi.',
        'prefix' => 'profil-irigasi',
    ], function () {
        Route::get('/', 'ProfilIrigasiController@index')->name('index');
        Route::get('kondisi-umum', 'ProfilIrigasiController@kondisiUmum')->name('kondisi-umum.index');
        Route::put('kondisi-umum', 'ProfilIrigasiController@kondisiUmumUpdate')->name('kondisi-umum.update');
    });

    Route::get('kuartal', 'QuarterController@index')->name('quarters.index');
    Route::get('kuartal/{quarter}', 'QuarterController@active')->name('quarters.active');

    Route::get('me', 'UserController@profile')->name('users.profile');
    Route::put('me', 'UserController@updateProfile')->name('users.update-profile');

    Route::get('logout', 'LoginController@logout')->name('auth.logout');
});
