<?php

use Illuminate\Support\Facades\Route;

Route::prefix('installer')->group(function () {
    Route::redirect('', 'requirements');

    Route::get('requirements', [\Leafwrap\LaravelInstaller\Http\Controllers\InstallerController::class, 'requirementsView'])
        ->name('requirements.index');
    Route::post('requirements', [\Leafwrap\LaravelInstaller\Http\Controllers\InstallerController::class, 'requirementsStore'])
        ->name('requirements.store');

    Route::get('permissions', [\Leafwrap\LaravelInstaller\Http\Controllers\InstallerController::class, 'permissionsView'])
        ->name('permissions.index');
    Route::post('permissions', [\Leafwrap\LaravelInstaller\Http\Controllers\InstallerController::class, 'permissionsStore'])
        ->name('permissions.store');

    Route::get('license', [\Leafwrap\LaravelInstaller\Http\Controllers\InstallerController::class, 'licenseView'])
        ->name('license.index');
    Route::post('license', [\Leafwrap\LaravelInstaller\Http\Controllers\InstallerController::class, 'licenseStore'])
        ->name('license.store');

    Route::get('database', [\Leafwrap\LaravelInstaller\Http\Controllers\InstallerController::class, 'databaseView'])
        ->name('database.index');
    Route::post('database', [\Leafwrap\LaravelInstaller\Http\Controllers\InstallerController::class, 'databaseStore'])
        ->name('database.store');

    Route::get('mail', [\Leafwrap\LaravelInstaller\Http\Controllers\InstallerController::class, 'mailView'])
        ->name('mail.index');
    Route::post('mail', [\Leafwrap\LaravelInstaller\Http\Controllers\InstallerController::class, 'mailStore'])
        ->name('mail.store');

    Route::get('install', [\Leafwrap\LaravelInstaller\Http\Controllers\InstallerController::class, 'installView'])
        ->name('install.index');
    Route::post('install', [\Leafwrap\LaravelInstaller\Http\Controllers\InstallerController::class, 'installStore'])
        ->name('install.store');

    Route::get('finish', [\Leafwrap\LaravelInstaller\Http\Controllers\InstallerController::class, 'finishView'])
        ->name('finish.index');
});
