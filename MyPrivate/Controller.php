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
namespace Modules\MyPrivate;

use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Module\ModuleAbstract;
use phpOMS\Module\WebInterface;

/**
 * Navigation class.
 *
 * @category   Modules
 * @package    Modules\Navigation
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
     * Module id.
     *
     * @var int
     * @since 1.0.0
     */
    /* public */ const MODULE_ID = 1003400000;

    /**
     * JavaScript files.
     *
     * @var string[]
     * @since 1.0.0
     */
    public static $js = [
        'backend',
    ];

    /**
     * CSS files.
     *
     * @var string[]
     * @since 1.0.0
     */
    public static $css = [
    ];

    /**
     * Module name.
     *
     * @var string
     * @since 1.0.0
     */
    /* public */ const MODULE_NAME = 'MyPrivate';

    /**
     * Localization files.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $localization = [
    ];

    /**
     * Providing.
     *
     * @var string[]
     * @since 1.0.0
     */
    protected static $providing = [
    ];

    /**
     * Dependencies.
     *
     * @var string[]
     * @since 1.0.0
     */
    protected static $dependencies = [
    ];

    /**
     * Constructor.
     *
     * @param \Web\WebApplication $app Application
     *
     * @since  1.0.0
     */
    public function __construct($app)
    {
        parent::__construct($app);
    }

    /**
     * {@inheritdoc}
     */
    public function call(RequestAbstract $request, ResponseAbstract $response, $data = null)
    {
    }
}
