<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'LoginController@index')->name('auth.index');
Route::post('/authentication', 'LoginController@authentication')->name('auth.login');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    Route::get('/me', 'UserController@profile')->name('users.profile');
    Route::get('/logout', 'LoginController@logout')->name('auth.logout');
});
