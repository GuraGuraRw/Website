<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbfddb6991c6cfd47d87a488ac643469a
{
    public static $files = array (
        'b45b351e6b6f7487d819961fef2fda77' => __DIR__ . '/..' . '/jakeasmith/http_build_url/src/http_build_url.php',
    );

    public static $classMap = array (
        'Contactform' => __DIR__ . '/../..' . '/contactform.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInitbfddb6991c6cfd47d87a488ac643469a::$classMap;

        }, null, ClassLoader::class);
    }
}
