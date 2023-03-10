<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1e65ffe3633b250109fe706844a16cc3
{
    public static $prefixLengthsPsr4 = array(
        'A' => array(
            'Leafwrap\\LaravelInstaller\\' => 24,
        ),
    );

    public static $prefixDirsPsr4 = array(
        'Leafwrap\\LaravelInstaller\\' => array(
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array(
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1e65ffe3633b250109fe706844a16cc3::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4    = ComposerStaticInit1e65ffe3633b250109fe706844a16cc3::$prefixDirsPsr4;
            $loader->classMap          = ComposerStaticInit1e65ffe3633b250109fe706844a16cc3::$classMap;

        }, null, ClassLoader::class);
    }
}
