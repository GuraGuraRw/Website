<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit5ad224427eb51708f695edd1c4c128e7
{
    public static $classMap = array (
        'Ps_Crossselling' => __DIR__ . '/../..' . '/ps_crossselling.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit5ad224427eb51708f695edd1c4c128e7::$classMap;

        }, null, ClassLoader::class);
    }
}
