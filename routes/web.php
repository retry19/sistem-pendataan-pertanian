<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'LoginController@index')->name('auth.index');
Route::post('authentication', 'LoginController@authentication')->name('auth.login');

Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    Route::resource('populasi-hewan', 'PopulasiHewanController')->except('create', 'show');

    Route::get('kepemilikan-hewan', 'KepemilikanHewanController@index')->name('kepemilikan-hewan.index');
    Route::post('kepemilikan-hewan', 'KepemilikanHewanController@store')->name('kepemilikan-hewan.store');
    Route::get('kepemilikan-hewan/{id}/edit', 'KepemilikanHewanController@edit')->name('kepemilikan-hewan.edit');
    Route::put('kepemilikan-hewan/{id}', 'KepemilikanHewanController@update')->name('kepemilikan-hewan.update');
    Route::delete('kepemilikan-hewan/{id}', 'KepemilikanHewanController@destroy')->name('kepemilikan-hewan.destroy');

    Route::get('luas-tanam', 'LuasTanamController@index')->name('luas-tanam.index');
    Route::post('luas-tanam', 'LuasTanamController@store')->name('luas-tanam.store');
    Route::get('luas-tanam/{id}/edit', 'LuasTanamController@edit')->name('luas-tanam.edit');
    Route::put('luas-tanam/{id}', 'LuasTanamController@update')->name('luas-tanam.update');
    Route::delete('luas-tanam/{id}', 'LuasTanamController@destroy')->name('luas-tanam.destroy');

    Route::resource('tanaman', 'TanamanController')->except('create', 'show');
    Route::resource('hewan', 'HewanController')->except('create', 'show');

    Route::get('kuartal', 'QuarterController@index')->name('quarters.index');
    Route::get('kuartal/{quarter}', 'QuarterController@active')->name('quarters.active');

    Route::resource('roles', 'RoleController')->except('create', 'show');
    Route::resource('permissions', 'PermissionController')->except('create', 'show');
    Route::resource('users', 'UserController')->except('create', 'show');

    Route::get('me', 'UserController@profile')->name('users.profile');
    Route::put('me', 'UserController@updateProfile')->name('users.update-profile');

    Route::get('logout', 'LoginController@logout')->name('auth.logout');
});
