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
namespace Web\Reporter;

use phpOMS\Asset\AssetType;
use phpOMS\DataStorage\Database\DatabaseStatus;
use phpOMS\Localization\Localization;
use phpOMS\Message\Http\RequestMethod;
use phpOMS\Views\View;

/**
 * Application class.
 *
 * @category   Framework
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Application
{

    /**
     * WebApplication.
     *
     * @var \Web\WebApplication
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
     * @param \Web\WebApplication $app    WebApplication
     * @param array               $config Application config
     *
     * @since  1.0.0
     */
    public function __construct($app, $config)
    {
        $this->app    = $app;
        $this->config = $config;
    }

    /**
     * Rendering reporter.
     *
     * @param \phpOMS\Message\Http\Request  $request  Request
     * @param \phpOMS\Message\Http\Response $response Response
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function run($request, $response)
    {
        $pageView = new View($this->app, $request, $response);

        if ($request->getMethod() !== RequestMethod::GET) {
            $response->setHeader('HTTP', 'HTTP/1.0 406 Not acceptable');
            $response->setHeader('Status', 'Status:406 Not acceptable');
            $response->setStatusCode(406);

            $pageView->setTemplate('/Web/Reporter/Error/406');
            $response->set('Content', $pageView);

            return;
        }

        if ($this->app->dbPool->get()->getStatus() !== DatabaseStatus::OK) {
            $response->setHeader('HTTP', 'HTTP/1.0 503 Service Temporarily Unavailable');
            $response->setHeader('Status', 'Status: 503 Service Temporarily Unavailable');
            $response->setHeader('Retry-After', 'Retry-After: 300');
            $response->setStatusCode(503);

            $pageView->setTemplate('/Web/Reporter/Error/503');
            $response->set('Content', $pageView);

            return;
        }

        $options = $this->app->appSettings->get([1000000009, 1000000029]);
        $account = $this->app->accountManager->get($request->getHeader()->getAccount());

        $l11n = new Localization();
        $l11n->setLanguage(!in_array($request->getHeader()->getL11n()->getLanguage(), $this->config['language']) ? $options[1000000029] : $request->getHeader()->getL11n()->getLanguage());
        $account->setL11n($l11n);
        $response->setL11n($l11n);

        /** @noinspection PhpIncludeInspection */
        include realpath(__DIR__ . '/Lang/' . $response->getHeader()->getL11n()->getLanguage() . '.lang.php');
        /** @var array $THEMELANG */
        $this->app->l11nManager->loadLanguage($response->getHeader()->getL11n()->getLanguage(), 0, $THEMELANG);

        /** @noinspection PhpIncludeInspection */
        include realpath(__DIR__ . '/../../phpOMS/Localization/Lang/' . $response->getHeader()->getL11n()->getLanguage() . '.lang.php');
        /** @var array $CORELANG */
        $this->app->l11nManager->loadLanguage($response->getHeader()->getL11n()->getLanguage(), 0, $CORELANG);

        /* Carefull we are setting an array here that's why changes in the future will result in different values */
        $response->getHeader()->getL11n()->setLang($this->app->l11nManager->getLanguage($l11n->getLanguage()));

        $head    = $response->getHead();
        $baseUri = $request->getUri()->getBase();

        if ($account->getId() < 1) {
            $head->addAsset(AssetType::CSS, $baseUri . 'Resources/fontawesome/css/font-awesome.min.css');
            $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/oms.min.js');
            $head->addAsset(AssetType::JS, $baseUri . 'Web/Reporter/js/reporter.js');
            $head->setScript('core', 'var Url = "' . $baseUri . '", assetManager = new jsOMS.AssetManager();');

            $pageView->setTemplate('/Web/Reporter/login');
            $response->set('Content', $pageView);

            return;
        }

        $modules = $this->app->moduleManager->getRoutedModules($request);
        $this->app->moduleManager->initModule($modules);
        $this->app->moduleManager->loadLanguage($response->getHeader()->getL11n()->getLanguage(), 'reporter');

        $head->addAsset(AssetType::CSS, $baseUri . 'Web/Reporter/css/reporter.css');
        $head->addAsset(AssetType::CSS, $baseUri . 'Resources/fontawesome/css/font-awesome.min.css');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/oms.min.js');
        $head->addAsset(AssetType::JS, $baseUri . 'Resources/d3/d3.min.js');
        $head->addAsset(AssetType::JS, $baseUri . 'Web/Reporter/js/reporter.js');
        $head->setStyle('core', file_get_contents(__DIR__ . '/css/reporter-small.css'));
        $head->setScript('core', 'var Url = "' . $baseUri . '", assetManager = new jsOMS.AssetManager();');

        $pageView->setData('Name', $options[1000000009]);
        $pageView->setData('Title', 'Orange Management');
        $pageView->setData('Destination', $request->getPath(1));

        $this->app->dispatcher->dispatch($this->app->router->route($request->getRoutify(), $request->getMethod()), $request, $response, null);

        $pageView->setTemplate('/Web/Reporter/index');
        $response->set('Content', $pageView);
    }
}
