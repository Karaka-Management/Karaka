<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Web\Error
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Web\E503;

use phpOMS\Localization\L11nManager;
use phpOMS\Message\Http\HttpRequest;
use phpOMS\Message\Http\HttpResponse;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\System\File\PathException;
use Web\WebApplication;

/**
 * Application class.
 *
 * @package Web\Error
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 * @codeCoverageIgnore
 */
final class Application
{
    /**
     * Application version
     *
     * @var string
     * @since 1.0.0
     */
    public const VERSION = '1.0.0';

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
     * @param WebApplication $app    Application
     * @param array          $config Configuration
     *
     * @since 1.0.0
     */
    public function __construct(WebApplication $app, array $config)
    {
        $this->app          = $app;
        $this->config       = $config;
        $this->app->appName = 'E503';
        $this->app->version = self::VERSION;
    }

    /**
     * Preparing response.
     *
     * @param HttpRequest  $request  Request
     * @param HttpResponse $response Response
     *
     * @return void
     *
     * @throws PathException
     *
     * @since 1.0.0
     */
    public function run(HttpRequest $request, HttpResponse $response) : void
    {
        $this->app->l11nManager = new L11nManager();

        if (!\in_array($response->header->l11n->language, $this->config['language'])) {
            $response->header->l11n->language = 'en';
        }

        $pageView = new ErrorView($this->app->l11nManager, $request, $response);
        $pageView->setTemplate('/Web/E503/index');

        /* Load theme language */
        if (($path = \realpath($oldPath = __DIR__ . '/lang/' . $response->header->l11n->language . '.lang.php')) === false) {
            throw new PathException($oldPath);
        }

        /** @noinspection PhpIncludeInspection */
        $themeLanguage = include $path;
        $this->app->l11nManager->loadLanguage($response->header->l11n->language, '0', $themeLanguage);

        $response->set('Content', $pageView);
        $response->header->status = RequestStatusCode::R_503;
    }
}
