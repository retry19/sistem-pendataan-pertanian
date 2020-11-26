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

    Route::get('tanaman-buah', 'TanamanBuahController@index')->name('tanaman-buah.index');
    Route::post('tanaman-buah', 'TanamanBuahController@store')->name('tanaman-buah.store');
    Route::get('tanaman-buah/{id}/edit', 'TanamanBuahController@edit')->name('tanaman-buah.edit');
    Route::put('tanaman-buah/{id}', 'TanamanBuahController@update')->name('tanaman-buah.update');
    Route::delete('tanaman-buah/{id}', 'TanamanBuahController@destroy')->name('tanaman-buah.destroy');

    Route::get('tanaman-obat', 'TanamanObatController@index')->name('tanaman-obat.index');
    Route::post('tanaman-obat', 'TanamanObatController@store')->name('tanaman-obat.store');
    Route::get('tanaman-obat/{id}/edit', 'TanamanObatController@edit')->name('tanaman-obat.edit');
    Route::put('tanaman-obat/{id}', 'TanamanObatController@update')->name('tanaman-obat.update');
    Route::delete('tanaman-obat/{id}', 'TanamanObatController@destroy')->name('tanaman-obat.destroy');

    Route::get('tanaman-kebun', 'TanamanKebunController@index')->name('tanaman-kebun.index');
    Route::post('tanaman-kebun', 'TanamanKebunController@store')->name('tanaman-kebun.store');
    Route::get('tanaman-kebun/{id}/edit', 'TanamanKebunController@edit')->name('tanaman-kebun.edit');
    Route::put('tanaman-kebun/{id}', 'TanamanKebunController@update')->name('tanaman-kebun.update');
    Route::delete('tanaman-kebun/{id}', 'TanamanKebunController@destroy')->name('tanaman-kebun.destroy');

    Route::resource('organisme-pengganggu', 'OrganismePenggangguController')->except('create', 'show');

    Route::resource('kepemilikan-lahan', 'KepemilikanLahanController')->except('create', 'show');

    Route::resource('dokumentasi', 'DokumentasiController')->except('create', 'show');

    Route::group(['prefix' => 'laporan', 'as' => 'laporan.'], function () {
        Route::get('tanaman-pangan-peternakan', 'LaporanController@tanamanPanganPeternakan')->name('tanaman-pangan-peternakan.index');
        Route::post('tanaman-pangan-peternakan', 'LaporanController@tanamanPanganPeternakanPDF')->name('tanaman-pangan-peternakan.store');
        Route::get('kepemilikan-lahan-pertanian', 'LaporanController@kepemilikanLahanPertanian')->name('kepemilikan-lahan-pertanian.index');
        Route::post('kepemilikan-lahan-pertanian', 'LaporanController@kepemilikanLahanPertanianPDF')->name('kepemilikan-lahan-pertanian.store');
        Route::get('kepemilikan-hewan-ternak', 'LaporanController@kepemilikanHewanTernak')->name('kepemilikan-hewan-ternak.index');
        Route::post('kepemilikan-hewan-ternak', 'LaporanController@kepemilikanHewanTernakPDF')->name('kepemilikan-hewan-ternak.store');
        Route::get('dokumentasi', 'LaporanController@dokumentasi')->name('dokumentasi.index');
        Route::post('dokumentasi', 'LaporanController@dokumentasiPDF')->name('dokumentasi.store');
    });

    Route::resource('tanaman', 'TanamanController')->except('create', 'show');
    Route::resource('hewan', 'HewanController')->except('create', 'show');
    Route::resource('kelompok-tani', 'KelompokTaniController')->except('create', 'show');

    Route::get('kuartal', 'QuarterController@index')->name('quarters.index');
    Route::get('kuartal/{quarter}', 'QuarterController@active')->name('quarters.active');

    Route::resource('roles', 'RoleController')->except('create', 'show');
    Route::resource('permissions', 'PermissionController')->except('create', 'show');
    Route::resource('users', 'UserController')->except('create', 'show');

    Route::get('me', 'UserController@profile')->name('users.profile');
    Route::put('me', 'UserController@updateProfile')->name('users.update-profile');

    Route::get('logout', 'LoginController@logout')->name('auth.logout');
});
