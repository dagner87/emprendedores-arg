<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf482adbc7aa0024375474f582d7781fc
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'TodoPago\\Test\\' => 14,
            'TodoPago\\' => 9,
        ),
        'D' => 
        array (
            'Decidir\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'TodoPago\\Test\\' => 
        array (
            0 => __DIR__ . '/..' . '/todopago/php-sdk/TodoPago/test',
        ),
        'TodoPago\\' => 
        array (
            0 => __DIR__ . '/..' . '/todopago/php-sdk/TodoPago/lib',
        ),
        'Decidir\\' => 
        array (
            0 => __DIR__ . '/..' . '/decidir2/php-sdk/Decidir/lib',
        ),
    );

    public static $prefixesPsr0 = array (
        'T' => 
        array (
            'TiendaNube' => 
            array (
                0 => __DIR__ . '/../..' . '/src',
            ),
        ),
        'R' => 
        array (
            'Requests' => 
            array (
                0 => __DIR__ . '/..' . '/rmccue/requests/library',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf482adbc7aa0024375474f582d7781fc::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf482adbc7aa0024375474f582d7781fc::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitf482adbc7aa0024375474f582d7781fc::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
