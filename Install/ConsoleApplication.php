<?php
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package   Install
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Install;

use phpOMS\Localization\Localization;
use phpOMS\Message\Console\ConsoleRequest;
use phpOMS\Message\Console\ConsoleResponse;
use phpOMS\Router\RouteVerb;
use phpOMS\Uri\Argument;

/**
 * Application class.
 *
 * @package Install
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 *
 * @property \phpOMS\Router\SocketRouter $router
 */
final class ConsoleApplication extends InstallAbstract
{
    /**
     * Temp config.
     *
     * @var array
     * @since 1.0.0
     */
    private array $config;

    /**
     * Constructor.
     *
     * @param array $config Core config
     * @param array $arg    Call argument
     *
     * @since 1.0.0
     */
    public function __construct(array $config, array $arg)
    {
        if (\PHP_SAPI !== 'cli') {
            throw new \Exception();
        }

        $this->config = $config;
        $this->initRequest($arg, __DIR__ . '/../', \locale_get_default());

        $this->setupHandlers();
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
     * @param ConsoleRequest $request Client request
     *
     * @return ConsoleResponse Initial client request
     *
     * @since 1.0.0
     */
    private function initResponse(ConsoleRequest $request) : ConsoleResponse
    {
        $response = new ConsoleResponse(new Localization());
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
