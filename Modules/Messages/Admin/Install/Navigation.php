<?php
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package   Modules\Messages\Admin\Install
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\Messages\Admin\Install;

use phpOMS\DataStorage\Database\DatabasePool;

/**
 * Navigation class.
 *
 * @package Modules\Messages\Admin\Install
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
class Navigation
{
    /**
     * Install navigation providing
     *
     * @param string       $path   Module path
     * @param DatabasePool $dbPool Database pool for database interaction
     *
     * @return void
     *
     * @since 1.0.0
     */
    public static function install(string $path, DatabasePool $dbPool) : void
    {
        \Modules\Navigation\Admin\Installer::installExternal($dbPool, ['path' => __DIR__ . '/Navigation.install.json']);
    }
}
