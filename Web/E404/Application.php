<?php
/**
 * Orange Management
 *
 * PHP Version 7.2
 *
 * @package    Web\Error
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
namespace Web\E404;

use phpOMS\Message\Http\Request;
use phpOMS\Message\Http\Response;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Localization\L11nManager;
use phpOMS\Message\Http\RequestMethod;
use phpOMS\System\File\PathException;
use phpOMS\Views\View;
use phpOMS\Asset\AssetType;
use phpOMS\Model\Html\Head;
use Web\WebApplication;

/**
 * Application class.
 *
 * @package    Web\Error
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Application
{
    /**
     * WebApplication.
     *
     * @var WebApplication
     * @since 1.0.0
     */
    private $app = null;

    /**
     * Config.
     *
     * @var array
     * @since 1.0.0
     */
    private $config = null;

    /**
     * Constructor.
     *
     * @param Webapplication $app    Application
     * @param array          $config Configuration
     *
     * @since  1.0.0
     */
    public function __construct(WebApplication $app, array $config)
    {
        $this->app          = $app;
        $this->config       = $config;
        $this->app->appName = 'E404';
    }

    /**
     * Preparing response.
     *
     * @param Request  $request  Request
     * @param Response $response Response
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function run(Request $request, Response $response) : void
    {
        $pageView = new View($this->app, $request, $response);
        $pageView->setTemplate('/Web/E404/index');

        /* Load theme language */
        if (($path = realpath($oldPath = __DIR__ . '/lang/' . $response->getHeader()->getL11n()->getLanguage() . '.lang.php')) === false) {
            throw new PathException($oldPath);
        }

        $this->app->l11nManager = new L11nManager();

        /** @noinspection PhpIncludeInspection */
        $themeLanguage = include $path;
        $this->app->l11nManager->loadLanguage($response->getHeader()->getL11n()->getLanguage(), 0, $themeLanguage);

        $response->set('Content', $pageView);
        $response->getHeader()->setStatusCode(RequestStatusCode::R_404);
    }
}
