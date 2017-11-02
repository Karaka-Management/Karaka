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
namespace Modules\Address;

use phpOMS\Message\RequestDestination;
use phpOMS\Module\ModuleAbstract;
use phpOMS\Module\WebInterface;

/**
 * Sales class.
 *
 * @category   Modules
 * @package    Modules\Accountsreceivable
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Controller extends ModuleAbstract implements WebInterface
{

    /**
     * Module path.
     *
     * @var string
     * @since 1.0.0
     */
    /* public */ const MODULE_PATH = __DIR__;

    /**
     * Module version.
     *
     * @var string
     * @since 1.0.0
     */
    /* public */ const MODULE_VERSION = '1.0.0';

    /**
     * Module name.
     *
     * @var string
     * @since 1.0.0
     */
    /* public */ const MODULE_NAME = 'Address';

    /**
     * Providing.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $providing = [
    ];

    /**
     * Dependencies.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $dependencies = [
    ];
}
