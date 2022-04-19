<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   Web\Error
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
 */
declare(strict_types=1);

namespace Web\E500;

use phpOMS\Asset\AssetType;
use phpOMS\Localization\L11nManager;
use phpOMS\Message\Http\HttpRequest;
use phpOMS\Message\Http\HttpResponse;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Model\Html\Head;
use phpOMS\System\File\PathException;
use phpOMS\Views\View;
use Web\WebApplication;

/**
 * Application class.
 *
 * @package Web\Error
 * @license OMS License 1.0
 * @link    https://karaka.app
 * @since   1.0.0
 * @codeCoverageIgnore
 */
final class Application
{
    /**
     * WebApplication.
     *
     * @var WebApplication
     * @since 1.0.0
     */
    private WebApplication $app;

    /**
     * Temp config.
     *
     * @var array
     * @since 1.0.0
     */
    private array $config = [];

    /**
     * Constructor.
     *
     * @param Webapplication $app    Application
     * @param array          $config Configuration
     *
     * @since 1.0.0
     */
    public function __construct(WebApplication $app, array $config)
    {
        $this->app          = $app;
        $this->config       = $config;
        $this->app->appName = 'E500';
    }

    /**
     * Preparing response.
     *
     * @param HttpRequest  $request  Request
     * @param HttpResponse $response Response
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function run(HttpRequest $request, HttpResponse $response) : void
    {
        $pageView = new View($this->app->l11nManager, $request, $response);
        $pageView->setTemplate('/Web/E500/index');
        $response->set('Content', $pageView);
        $response->header->status = RequestStatusCode::R_500;

        /* Load theme language */
        if (($path = \realpath($oldPath = __DIR__ . '/lang/' . $response->getLanguage() . '.lang.php')) === false) {
            throw new PathException($oldPath);
        }

        $this->app->l11nManager = new L11nManager($this->app->appName);

        /** @noinspection PhpIncludeInspection */
        $themeLanguage = include $path;
        $this->app->l11nManager->loadLanguage($response->getLanguage(), '0', $themeLanguage);

        $head    = new Head();
        $baseUri = $request->uri->getBase();
        $head->addAsset(AssetType::CSS, $baseUri . 'cssOMS/styles.css');

        $pageView->setData('head', $head);
    }
}
