<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   TBD
 * @package    TBD
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://orange-management.com
 */
declare(strict_types = 1);

namespace phpOMS\System\File;

/**
 * Filesystem class.
 *
 * Performing operations on the file system
 *
 * @category   Framework
 * @package    phpOMS\System\File
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
final class Storage
{
    /**
     * Registered storage.
     *
     * @var array
     * @since 1.0.0
     */
    private static $registered = [];
    
    /**
     * Constructor.
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    private function __construct()
    {
        
    }

    /**
     * Get registred env instance.
     *
     * @param string $env Environment name
     *
     * @return StorageAbstract
     *
     * @throws \Exception Throws exception in case of invalid storage
     *
     * @since  1.0.0
     */
    public static function env(string $env = 'local') : StorageAbstract
    {
        if (isset(self::$registered[$env])) {
            if (is_string(self::$registered[$env])) {
                $env = self::$registered[$env]::getInstance();
            } elseif (self::$registered[$env] instanceof StorageAbstract || self::$registered[$env] instanceof ContainerInterface) {
                $env = self::$registered[$env];
            } else {
                throw new \Exception('Invalid type');
            }
        } else {
            $stg = $env;
            $env = ucfirst(strtolower($env));
            $env = __NAMESPACE__ . '\\' . $env . '\\' . $env . 'Storage';

            try {
                /** @var StorageAbstract $env */
                $env = $env::getInstance();

                self::$registered[$stg] = $env;
            } catch (\Throwable $e) {
                throw new \Exception();
            }
        }

        return $env;
    }

    /**
     * Register storage environment.
     *
     * @param string $name Name of the environment
     * @param string|StorageAbstract|mixed $class Class to register. This can be either a namespace path, a anonymous class or storage implementation.
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public static function register(string $name, $class) : bool
    {
        if (isset(self::$registered[$name])) {
            return false;
        }

        self::$registered[$name] = $class;

        return true;
    }
}
