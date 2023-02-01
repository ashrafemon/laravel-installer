<?php

use Illuminate\Support\Facades\Route;

Route::prefix('installer')->group(function () {
    Route::redirect('', 'requirements');

    Route::get('requirements', [\Ashraf\LaravelInstaller\Http\Controllers\InstallerController::class, 'requirementsView'])
        ->name('requirements.index');
    Route::post('requirements', [\Ashraf\LaravelInstaller\Http\Controllers\InstallerController::class, 'requirementsStore'])
        ->name('requirements.store');

    Route::get('permissions', [\Ashraf\LaravelInstaller\Http\Controllers\InstallerController::class, 'permissionsView'])
        ->name('permissions.index');
    Route::post('permissions', [\Ashraf\LaravelInstaller\Http\Controllers\InstallerController::class, 'permissionsStore'])
        ->name('permissions.store');

    Route::get('license', [\Ashraf\LaravelInstaller\Http\Controllers\InstallerController::class, 'licenseView'])
        ->name('license.index');
    Route::post('license', [\Ashraf\LaravelInstaller\Http\Controllers\InstallerController::class, 'licenseStore'])
        ->name('license.store');

    Route::get('database', [\Ashraf\LaravelInstaller\Http\Controllers\InstallerController::class, 'databaseView'])
        ->name('database.index');
    Route::post('database', [\Ashraf\LaravelInstaller\Http\Controllers\InstallerController::class, 'databaseStore'])
        ->name('database.store');

    Route::get('mail', [\Ashraf\LaravelInstaller\Http\Controllers\InstallerController::class, 'mailView'])
        ->name('mail.index');
    Route::post('mail', [\Ashraf\LaravelInstaller\Http\Controllers\InstallerController::class, 'mailStore'])
        ->name('mail.store');

    Route::get('install', [\Ashraf\LaravelInstaller\Http\Controllers\InstallerController::class, 'installView'])
        ->name('install.index');
    Route::post('install', [\Ashraf\LaravelInstaller\Http\Controllers\InstallerController::class, 'installStore'])
        ->name('install.store');

    Route::get('finish', [\Ashraf\LaravelInstaller\Http\Controllers\InstallerController::class, 'finishView'])
        ->name('finish.index');
});
