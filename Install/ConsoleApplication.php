<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   Install
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Install;

use phpOMS\Localization\Localization;
use phpOMS\Message\Console\ConsoleRequest;
use phpOMS\Message\Console\ConsoleResponse;
use phpOMS\Dispatcher\Dispatcher;
use phpOMS\Router\RouteVerb;
use phpOMS\Router\SocketRouter;
use phpOMS\Uri\Argument;

/**
 * Application class.
 *
 * @package Install
 * @license OMS License 1.0
 * @link    https://jingga.app
 * @since   1.0.0
 *
 * @property \phpOMS\Router\SocketRouter $router
 */
final class ConsoleApplication extends InstallAbstract
{

    /**
     * Constructor.
     *
     * @param array $arg Call argument
     *
     * @since 1.0.0
     */
    public function __construct(array $arg)
    {
        if (\PHP_SAPI !== 'cli') {
            throw new \Exception();
        }

        $this->setupHandlers();

        $request  = $this->initRequest($arg, __DIR__ . '/../', \locale_get_default());
        $response = $this->initResponse($request, ['en', 'de']);

        $this->run($request, $response);

        echo $response->getBody();
    }

    /**
     * Initialize current application request
     *
     * @param array  $arg      Cli arguments
     * @param string $rootPath Web root path
     * @param string $language Fallback language
     *
     * @return ConsoleRequest Initial client request
     *
     * @since 1.0.0
     */
    private function initRequest(array $arg, string $rootPath, string $language) : ConsoleRequest
    {
        $request = new ConsoleRequest(new Argument($arg[1] ?? ''));

        return $request;
    }

    /**
     * Initialize basic response
     *
     * @param ConsoleRequest $request   Client request
     * @param array          $languages Supported languages
     *
     * @return ConsoleResponse Initial client request
     *
     * @since 1.0.0
     */
    private function initResponse(ConsoleRequest $request, array $languages) : ConsoleResponse
    {
        $response = new ConsoleResponse(new Localization());

        $response->header->l11n->setLanguage(
            !\in_array($request->getLanguage(), $languages) ? 'en' : $request->getLanguage()
        );

        return $response;
    }

    /**
     * Rendering install.
     *
     * @param ConsoleRequest  $request  Request
     * @param ConsoleResponse $response Response
     *
     * @return void
     *
     * @since 1.0.0
     */
    private function run(ConsoleRequest $request, ConsoleResponse $response) : void
    {
        $this->dispatcher = new Dispatcher($this);
        $this->router     = new SocketRouter();

        $this->setupRoutes();

        $this->dispatcher->dispatch(
            $this->router->route(
                $request->uri->getRoute(),
                $request->getData('CSRF'),
                $request->getRouteVerb()
            ),
            $request,
            $response
        );
    }

    /**
     * Setup routes for installer
     *
     * @return void
     *
     * @since 1.0.0
     */
    private function setupRoutes() : void
    {
        $this->router->add('^.*', '\Install\WebApplication::installView');
        $this->router->add('^.*', '\Install\WebApplication::installRequest');
    }
}
