<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitfce857dcde0390c91366c53965c47b3e
{
    public static $files = array (
        'b2cce259ff21ae1c7fff8bb0a034254b' => __DIR__ . '/../..' . '/src/config.php',
    );

    public static $prefixLengthsPsr4 = array (
        's' => 
        array (
            'src\\' => 4,
        ),
        'Z' => 
        array (
            'Zamplate\\' => 9,
        ),
        'C' => 
        array (
            'Controllers\\' => 12,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'src\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Zamplate\\' => 
        array (
            0 => __DIR__ . '/..' . '/zambiank/zamplate/src',
        ),
        'Controllers\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app/controllers',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitfce857dcde0390c91366c53965c47b3e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitfce857dcde0390c91366c53965c47b3e::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitfce857dcde0390c91366c53965c47b3e::$classMap;

        }, null, ClassLoader::class);
    }
}
