<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @package    TBD
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
declare(strict_types = 1);

namespace Tests\PHPUnit;

spl_autoload_register('\Tests\PHPUnit\Autoloader::default_autoloader');

/**
 * Autoloader class.
 *
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
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
     * @throws AutoloadException Throws this exception if the class to autoload doesn't exist. This could also be related to a wrong namespace/file path correlation.
     *
     * @since  1.0.0
     */
    public static function default_autoloader(string $class) /* : void */
    {
        $class = ltrim($class, '\\');
        $class = str_replace(['_', '\\'], '/', $class);

        if (!file_exists($path = __DIR__ . '/../../' . $class . '.php')) {
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
     * @since  1.0.0
     */
    public static function exists(string $class) : bool
    {
        $class = ltrim($class, '\\');
        $class = str_replace(['_', '\\'], '/', $class);

        return file_exists(__DIR__ . '/../../' . $class . '.php');
    }

}
