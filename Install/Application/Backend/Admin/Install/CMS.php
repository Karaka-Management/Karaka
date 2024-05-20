<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Web\Backend\Admin\Install
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Web\Backend\Admin\Install;

use phpOMS\Application\ApplicationAbstract;

/**
 * Navigation class.
 *
 * @package Web\Backend\Admin\Install
 * @license OMS License 2.2
 * @link    https://jingga.app
 * @since   1.0.0
 */
class CMS
{
    /**
     * Install media providing
     *
     * @param ApplicationAbstract $app  Application
     * @param string              $path Module path
     *
     * @return void
     *
     * @since 1.0.0
     */
    public static function install(ApplicationAbstract $app, string $path) : void
    {
        $app = \Modules\CMS\Admin\Installer::installExternal($app, ['path' => __DIR__ . '/CMS.install.json']);
    }
}
