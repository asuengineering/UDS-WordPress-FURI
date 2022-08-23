<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit32858cdf11e8fe1aaf7367fc60351416
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInit32858cdf11e8fe1aaf7367fc60351416', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit32858cdf11e8fe1aaf7367fc60351416', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit32858cdf11e8fe1aaf7367fc60351416::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}