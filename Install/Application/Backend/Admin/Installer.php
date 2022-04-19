<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   Web\Backend\Admin
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
 */
declare(strict_types=1);

namespace Web\Backend\Admin;

use phpOMS\Application\InstallerAbstract;

/**
 * Installer class.
 *
 * @package Web\Backend\Admin
 * @license OMS License 1.0
 * @link    https://karaka.app
 * @since   1.0.0
 */
final class Installer extends InstallerAbstract
{
    /**
     * Application path
     *
     * @var string
     * @since 1.0.0
     */
    public const PATH = __DIR__;
}
