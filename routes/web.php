<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'LoginController@index')->name('auth.index');
Route::post('authentication', 'LoginController@authentication')->name('auth.login');

Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    Route::group(['prefix' => 'peternakan'], function () {
        Route::resource('populasi-hewan', 'PopulasiHewanController')->except('create', 'show');
    });

    Route::resource('hewan', 'HewanController')->except('create', 'show');

    Route::get('kuartal', 'QuarterController@index')->name('quarters.index');
    Route::get('kuartal/{quarter}', 'QuarterController@active')->name('quarters.active');

    Route::resource('roles', 'RoleController');
    Route::resource('permissions', 'PermissionController');

    Route::get('me', 'UserController@profile')->name('users.profile');
    Route::put('me', 'UserController@updateProfile')->name('users.update-profile');

    Route::get('logout', 'LoginController@logout')->name('auth.logout');
});
