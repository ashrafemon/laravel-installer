<?php

namespace Leafwrap\LaravelInstaller;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;
use Leafwrap\LaravelInstaller\Http\Middleware\InstallChecker;

class LaravelInstallerServiceProvider extends ServiceProvider
{
    public function boot(Kernel $kernel)
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/views', 'laravel-installer');
        $this->mergeConfigFrom(__DIR__ . '/config/laravel-installer.php', 'laravel-installer');
        $this->mergeConfigFrom(__DIR__ . '/config/laravel-constants.php', 'laravel-constants');
        $kernel->pushMiddleware(InstallChecker::class);
        // $this->publishes([
        //     __DIR__ . '/config/laravel-installer.php' => config_path('laravel-installer.php'),
        // ]);

    }

    public function register()
    {
        parent::register(); // TODO: Change the autogenerated stub
    }
}
