<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   Web\Backend\Admin\Install
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Web\Backend\Admin\Install;

use phpOMS\Application\ApplicationAbstract;

/**
 * Navigation class.
 *
 * @package Web\Backend\Admin\Install
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
class Navigation
{
    /**
     * Install navigation providing
     *
     * @param string              $path Module path
     * @param ApplicationAbstract $app  Application
     *
     * @return void
     *
     * @since 1.0.0
     */
    public static function install(string $path, ApplicationAbstract $app) : void
    {
        \Modules\Navigation\Admin\Installer::installExternal($app,
            [
                'path' => __DIR__ . '/Navigation.install.json',
                'app' => 2,
            ]
        );
    }
}
