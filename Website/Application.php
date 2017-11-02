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
namespace Web\Website;

use phpOMS\Asset\AssetType;
use phpOMS\DataStorage\Database\DatabaseStatus;
use phpOMS\Localization\Localization;
use phpOMS\Message\Http\Request;
use phpOMS\Message\Http\Response;
use phpOMS\Message\Http\RequestMethod;
use phpOMS\Views\View;
use Web\WebApplication;

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
     * @param WebApplication $app    WebApplication
     * @param array               $config Application config
     *
     * @since  1.0.0
     */
    public function __construct(WebApplication $app, array $config)
    {
        $this->app    = $app;
        $this->config = $config;
    }

    /**
     * Rendering backend.
     *
     * @param Request  $request  Request
     * @param Response $response Response
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function run(Request $request, Response $response)
    {
        $pageView = new View($this->app, $request, $response);

        if ($request->getMethod() !== RequestMethod::GET) {
            $response->setHeader('HTTP', 'HTTP/1.0 406 Not acceptable');
            $response->setHeader('Status', 'Status:406 Not acceptable');
            $response->setStatusCode(406);

            $pageView->setTemplate('/Web/Backend/Error/406');
            $response->set('Content', $pageView);

            return;
        }

        if ($this->app->dbPool->get()->getStatus() !== DatabaseStatus::OK) {
            $response->setHeader('HTTP', 'HTTP/1.0 503 Service Temporarily Unavailable');
            $response->setHeader('Status', 'Status: 503 Service Temporarily Unavailable');
            $response->setHeader('Retry-After', 'Retry-After: 300');
            $response->setStatusCode(503);

            $pageView->setTemplate('/Web/Backend/Error/503');
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
        /** @var array $THEMELANG Theme language */
        $this->app->l11nManager->loadLanguage($response->getHeader()->getL11n()->getLanguage(), 0, $THEMELANG);

        /** @noinspection PhpIncludeInspection */
        include realpath(__DIR__ . '/../../phpOMS/Localization/Lang/' . $response->getHeader()->getL11n()->getLanguage() . '.lang.php');
        /** @var array $CORELANG Framework language elements */
        $this->app->l11nManager->loadLanguage($response->getHeader()->getL11n()->getLanguage(), 0, $CORELANG);

        /* TODO: WHY AM I DOING THIS? Carefull we are setting an array here that's why changes in the future will result in different values */
        $response->getHeader()->getL11n()->setLang($this->app->l11nManager->getLanguage($l11n->getLanguage()));

        $head    = $response->getHead();
        $baseUri = $request->getUri()->getBase();

        $modules = $this->app->moduleManager->getRoutedModules($request);
        $this->app->moduleManager->initModule($modules);
        $this->app->moduleManager->loadLanguage($response->getHeader()->getL11n()->getLanguage(), 'Backend');

        $head->addAsset(AssetType::CSS, $baseUri . 'Web/Website/css/website.css');
        $head->addAsset(AssetType::CSS, $baseUri . 'Resources/fontawesome/css/font-awesome.min.css');
        $head->addAsset(AssetType::CSS, 'http://fonts.googleapis.com/css?family=Open+Sans');
        $head->addAsset(AssetType::JS, $baseUri . 'jsOMS/oms.min.js');
        $head->addAsset(AssetType::JS, $baseUri . 'Resources/d3/d3.min.js');
        $head->addAsset(AssetType::JS, $baseUri . 'Web/Website/js/website.js');
        //$head->setStyle('core', file_get_contents(__DIR__ . '/css/website-small.css'));
        $head->setScript('core', 'var Url = "' . $baseUri . '", assetManager = new jsOMS.AssetManager();');

        $pageView->setData('Name', $options[1000000009]);
        $pageView->setData('Title', 'Orange Management');
        $pageView->setData('Destination', $request->getPath(1));

        $pageView->setTemplate('/Web/Website/index');
        $response->set('Content', $pageView);

        $this->app->dispatcher->dispatch($this->app->router->route($request->getRoutify(), $request->getMethod()), $request, $response, null);
    }
}
