<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   Framework
 * @package    phpOMS\Module
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
declare(strict_types = 1);

namespace phpOMS\Module;

use phpOMS\Autoloader;
use phpOMS\ApplicationAbstract;

/**
 * ModuleFactory class.
 *
 * Responsible for initializing modules as singletons
 *
 * @category   Framework
 * @package    phpOMS\Module
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class ModuleFactory
{

    /**
     * Module instances.
     *
     * Reference to module.class
     *
     * @var ModuleAbstract[]
     * @since 1.0.0
     */
    public static $loaded = [];

    /**
     * Unassigned providing.
     *
     * @var string[][]
     * @since 1.0.0
     */
    public static $providing = [];

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
     * Gets and initializes modules.
     *
     * @param string              $module Module ID
     * @param ApplicationAbstract $app    Application
     *
     * @return ModuleAbstract
     *
     * @since  1.0.0
     */
    public static function getInstance(string $module, ApplicationAbstract $app) : ModuleAbstract
    {
        $class = '\\Modules\\' . $module . '\\Controller';

        if (!isset(self::$loaded[$module])) {
            if (Autoloader::exists($class) !== false) {
                try {
                    $obj                   = new $class($app);
                    self::$loaded[$module] = $obj;
                    self::registerRequesting($obj);
                    self::registerProvided($obj);
                } catch (\Exception $e) {
                    self::$loaded[$module] = new NullModule($app);
                }
            } else {
                self::$loaded[$module] = new NullModule($app);
            }
        }

        return self::$loaded[$module];
    }

    /**
     * Load modules this module is requesting from
     *
     * @param ModuleAbstract $obj Current module
     *
     * @since  1.0.0
     */
    private static function registerRequesting(ModuleAbstract $obj) /* : void */
    {
        foreach ($obj->getProviding() as $providing) {
            if (isset(self::$loaded[$providing])) {
                self::$loaded[$providing]->addReceiving($obj->getName());
            } else {
                self::$providing[$providing][] = $obj->getName();
            }
        }
    }

    /**
     * Register modules this module is receiving from
     *
     * @param ModuleAbstract $obj Current module
     *
     * @since  1.0.0
     */
    private static function registerProvided(ModuleAbstract $obj) /* : void */
    {
        $name = $obj->getName();
        if (isset(self::$providing[$name])) {
            foreach (self::$providing[$name] as $providing) {
                self::$loaded[$name]->addReceiving($providing);
            }
        }
    }
}
