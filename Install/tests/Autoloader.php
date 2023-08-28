<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Install\tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Install\tests;

\spl_autoload_register('\Install\tests\Autoloader::default_autoloader');

/**
 * Autoloader class.
 *
 * @package Install\tests
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
class Autoloader
{
    /**
     * Loading classes by namespace + class name.
     *
     * @param string $class Class path
     *
     * @example Autoloader::default_autoloader('\Tests\PHPUnit\Autoloader') // void
     *
     * @return void
     *
     * @since 1.0.0
     */
    public static function default_autoloader(string $class) : void
    {
        $class = \ltrim($class, '\\');
        $class = \strtr($class, '_\\', '//');

        if (!\is_file($path = __DIR__ . '/../../' . $class . '.php')) {
            return;
        }

        /** @noinspection PhpIncludeInspection */
        include_once $path;
    }

    /**
     * Check if class exists.
     *
     * @param string $class Class path
     *
     * @example Autoloader::exists('\Tests\PHPUnit\Autoloader') // true
     *
     * @return bool
     *
     * @since 1.0.0
     */
    public static function exists(string $class) : bool
    {
        $class = \ltrim($class, '\\');
        $class = \strtr($class, '_\\', '//');

        return \is_file(__DIR__ . '/../../' . $class . '.php');
    }
}
