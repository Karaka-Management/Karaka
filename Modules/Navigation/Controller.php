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
namespace Modules\Navigation;

use Modules\Navigation\Models\Navigation;
use Modules\Navigation\Models\NavigationType;
use Modules\Navigation\Views\NavigationView;
use phpOMS\Contract\RenderableInterface;
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
 * @link       http://website.orange-management.de
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
    /* public */ const MODULE_NAME = 'Navigation';

    /**
     * Module id.
     *
     * @var int
     * @since 1.0.0
     */
    /* public */ const MODULE_ID = 1000500000;

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
     * @param int              $pageId   Page/parent Id for navigation
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     *
     * @return RenderableInterface
     *
     * @since  1.0.0
     */
    public function createNavigationMid(int $pageId, RequestAbstract $request, ResponseAbstract $response)
    {
        $nav     = Navigation::getInstance($request, $this->app->dbPool);
        $navView = new NavigationView($this->app, $request, $response);
        $navView->setTemplate('/Modules/Navigation/Theme/Backend/mid');
        $navView->setNav($nav->getNav());
        $navView->setLanguage($request->getHeader()->getL11n()->getLanguage());
        $navView->setParent($pageId);

        return $navView;
    }

    public function getView(RequestAbstract $request, ResponseAbstract $response)
    {
        $navObj = \Modules\Navigation\Models\Navigation::getInstance($request, $this->app->dbPool);
        $nav = new \Modules\Navigation\Views\NavigationView($this->app, $request, $response);
        $nav->setNav($navObj->getNav());
        $nav->setLanguage($request->getHeader()->getL11n()->getLanguage());
        $unread = [];

        foreach ($this->receiving as $receiving) {
            $unread[$receiving] = $this->app->moduleManager->get($receiving)->openNav($request->getHeader()->getAccount());
        }

        $nav->setData('unread', $unread);

        return $nav;
    }

    public function loadLanguage(RequestAbstract $request, ResponseAbstract $response) {
        $languages = $this->app->moduleManager->getLanguageFiles($request);

        foreach ($languages as $path) {
            if ($path[strlen($path) - 1] === '/') {
                // Is not a navigation file
                continue;
            }

            $path = __DIR__ . '/../..' . $path . '.' . $response->getHeader()->getL11n()->getLanguage() . '.lang.php';

            /** @noinspection PhpIncludeInspection */
            $lang = include $path;
            $this->app->l11nManager->loadLanguage($response->getHeader()->getL11n()->getLanguage(), 'Navigation', $lang);
        }
    }

    /**
     * @param int              $pageId   Page/parent Id for navigation
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     *
     * @return RenderableInterface
     *
     * @since  1.0.0
     */
    public function createNavigationSplash(int $pageId, RequestAbstract $request, ResponseAbstract $response)
    {
        $nav     = Navigation::getInstance($request, $this->app->dbPool);
        $navView = new NavigationView($this->app, $request, $response);
        $navView->setTemplate('/Modules/Navigation/Theme/Backend/splash');
        $navView->setNav($nav->getNav());
        $navView->setLanguage($request->getHeader()->getL11n()->getLanguage());
        $navView->setParent($pageId);

        return $navView;
    }
}
