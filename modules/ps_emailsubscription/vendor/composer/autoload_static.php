<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit390db16647e83983fc69ecb8f655c914
{
    public static $classMap = array (
        'Ps_Emailsubscription' => __DIR__ . '/../..' . '/ps_emailsubscription.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit390db16647e83983fc69ecb8f655c914::$classMap;

        }, null, ClassLoader::class);
    }
}
