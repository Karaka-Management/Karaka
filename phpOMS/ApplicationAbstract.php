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
 * @link       http://website.orange-management.de
 */
declare(strict_types = 1);

namespace phpOMS;

/**
 * Application class.
 *
 * @category   Framework
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class ApplicationAbstract
{

    /**
     * App name.
     *
     * @var string
     * @since 1.0.0
     */
    protected $appName = '';

    /**
     * Database object.
     *
     * @var \phpOMS\DataStorage\Database\DatabasePool
     * @since 1.0.0
     */
    protected $dbPool = null;

    /**
     * Application settings object.
     *
     * @var \Model\CoreSettings
     * @since 1.0.0
     */
    protected $appSettings = null;

    /**
     * Account manager instance.
     *
     * @var \phpOMS\Account\AccountManager
     * @since 1.0.0
     */
    protected $accountManager = null;

    /**
     * Cache instance.
     *
     * @var \phpOMS\DataStorage\Cache\CachePool
     * @since 1.0.0
     */
    protected $cachePool = null;

    /**
     * ModuleManager instance.
     *
     * @var \phpOMS\Module\ModuleManager
     * @since 1.0.0
     */
    protected $moduleManager = null;

    /**
     * Router instance.
     *
     * @var \phpOMS\Router\Router
     * @since 1.0.0
     */
    protected $router = null;

    /**
     * Dispatcher instance.
     *
     * @var \phpOMS\Dispatcher\Dispatcher
     * @since 1.0.0
     */
    protected $dispatcher = null;

    /**
     * Session instance.
     *
     * @var \phpOMS\DataStorage\Session\SessionInterface
     * @since 1.0.0
     */
    protected $sessionManager = null;

    /**
     * Server localization.
     *
     * @var \phpOMS\Localization\Localization
     * @since 1.0.0
     */
    protected $l11nServer = null;

    /**
     * Server localization.
     *
     * @var \phpOMS\Log\FileLogger
     * @since 1.0.0
     */
    protected $logger = null;

    /**
     * L11n manager.
     *
     * @var \phpOMS\Localization\L11nManager
     * @since 1.0.0
     */
    protected $l11nManager = null;

    /**
     * Event manager.
     *
     * @var \phpOMS\Event\EventManager
     * @since 1.0.0
     */
    protected $eventManager = null;

    /**
     * Set values
     *
     * @param string $name Variable name
     * @param string $value Variable value
     *
     * @return void
     *
     * @todo replace with proper setter (faster)
     *
     * @since  1.0.0
     */
    public function __set($name, $value) 
    {
        if (!empty($this->$name)) {
            return;
        }

        $this->$name = $value;
    }

    /**
     * Get values
     *
     * @param string $name Variable name
     *
     * @return mixed
     *
     * @todo replace with proper getter (faster)
     *
     * @since  1.0.0
     */
    public function __get($name) 
    { 
        return $this->$name; 
    }
}
