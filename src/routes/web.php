<?php

use Illuminate\Support\Facades\Route;

Route::prefix('installer')->group(function () {
    Route::redirect('', 'installer/requirements');

    Route::view('requirements', 'laravel-installer::pages.requirements')->name('requirements.index');
    Route::view('permissions', 'laravel-installer::pages.permissions')->name('permissions.index');
    Route::view('license', 'laravel-installer::pages.license')->name('license.index');
    Route::view('database', 'laravel-installer::pages.database')->name('database.index');
    Route::view('install', 'laravel-installer::pages.install')->name('install.index');
    Route::view('finish', 'laravel-installer::pages.finish')->name('finish.index');
});

Route::prefix('api/v1')->middleware('api')->group(function () {
    Route::prefix('extensions')->group(function () {
        Route::get('', [\Leafwrap\LaravelInstaller\Http\Controllers\InstallerController::class, 'getExtensions']);
        Route::post('validate', [\Leafwrap\LaravelInstaller\Http\Controllers\InstallerController::class, 'validateExtensions']);
    });

    Route::prefix('permissions')->group(function () {
        Route::get('', [\Leafwrap\LaravelInstaller\Http\Controllers\InstallerController::class, 'getPermissions']);
        Route::post('validate', [\Leafwrap\LaravelInstaller\Http\Controllers\InstallerController::class, 'validatePermissions']);
    });

    Route::get('products', [\Leafwrap\LaravelInstaller\Http\Controllers\InstallerController::class, 'getProducts']);
    Route::post('licenses/validate', [\Leafwrap\LaravelInstaller\Http\Controllers\InstallerController::class, 'validateLicenses']);

    Route::prefix('databases')->group(function () {
        Route::get('', [\Leafwrap\LaravelInstaller\Http\Controllers\InstallerController::class, 'getDatabases']);
        Route::post('validate', [\Leafwrap\LaravelInstaller\Http\Controllers\InstallerController::class, 'validateDatabases']);
    });

    Route::post('install/validate', [\Leafwrap\LaravelInstaller\Http\Controllers\InstallerController::class, 'validateInstallation']);
});
