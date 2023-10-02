<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace tests;

\spl_autoload_register('\tests\Autoloader::defaultAutoloader');

/**
 * Autoloader class.
 *
 * @package tests
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
final class Autoloader
{
    /**
     * Base paths for autoloading
     *
     * @var string[]
     * @since 1.0.0
     */
    private static $paths = [
        __DIR__ . '/../',
        __DIR__ . '/../../',
    ];

    /**
     * Constructor.
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    private function __construct()
    {
    }

    /**
     * Add base path for autoloading
     *
     * @param string $path Absolute base path with / at the end
     *
     * @return void
     *
     * @since 1.0.0
     */
    public static function addPath(string $path) : void
    {
        self::$paths[] = \rtrim($path, '/\\') . '/';
    }

    /**
     * Loading classes by namespace + class name.
     *
     * @param string $class Class path
     *
     * @example Autoloader::defaultAutoloader('\phpOMS\Autoloader') // void
     *
     * @return void
     *
     * @since 1.0.0
     */
    public static function defaultAutoloader(string $class) : void
    {
        $class = \ltrim($class, '\\');
        $class = \strtr($class, '_\\', '//');

        if (\stripos($class, 'Web/Backend') !== false || \stripos($class, 'Web/Api') !== false) {
            $class = \is_dir(__DIR__ . '/Web') ? $class : \str_replace('Web/', 'MainRepository/Web/', $class);
        }

        $class2 = $class;

        foreach (self::$paths as $path) {
            if (\is_file($file = $path . $class2 . '.php')) {
                include_once $file;

                return;
            } elseif (\is_file($file = $path . $class . '.php')) {
                include_once $file;

                return;
            }
        }
    }

    /**
     * Check if class exists.
     *
     * @param string $class Class path
     *
     * @example Autoloader::exists('\phpOMS\Autoloader') // true
     *
     * @return bool
     *
     * @since 1.0.0
     */
    public static function exists(string $class) : bool
    {
        $class = \ltrim($class, '\\');
        $class = \strtr($class, '_\\', '//');

        foreach (self::$paths as $path) {
            if (\is_file($path . $class . '.php')) {
                return true;
            }
        }

        return false;
    }
}
