<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit74c860f8bc11ac2f8a01c35e8c522af9
{
    public static $prefixLengthsPsr4 = array (
        'L' => 
        array (
            'LLMS\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'LLMS\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit74c860f8bc11ac2f8a01c35e8c522af9::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit74c860f8bc11ac2f8a01c35e8c522af9::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
