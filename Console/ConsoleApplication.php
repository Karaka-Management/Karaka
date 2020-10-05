<?php
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package    Console
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://orange-management.com
 */
declare(strict_types=1);

namespace Console;

use phpOMS\Application\ApplicationAbstract;
use phpOMS\DataStorage\Session\FileSessionHandler;
use phpOMS\Localization\Localization;
use phpOMS\Log\FileLogger;
use phpOMS\Message\Console\ConsoleRequest;
use phpOMS\Message\Console\ConsoleResponse;
use phpOMS\Uri\Argument;

/**
 * Application class.
 *
 * @package    Console
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
final class ConsoleApplication extends ApplicationAbstract
{
    /**
     * Temp config.
     *
     * @var array{log:array{file:array{path:string}}, app:array{path:string, default:string, domains:array}, page:array{root:string, https:bool}, language:string[], db:array{core:array{masters:array{admin:array{db:string, database:string}, insert:array{db:string, database:string}, select:array{db:string, database:string}, update:array{db:string, database:string}, delete:array{db:string, database:string}, schema:array{db:string, database:string}}}}}
     * @since 1.0.0
     */
    private array $config;

    /**
     * Constructor.
     *
     * @param string[]                                                                                                                                                                                                                                                                                                                                                                                                                                                 $arg    Call argument
     * @param array{log:array{file:array{path:string}}, app:array{path:string, default:string, domains:array}, page:array{root:string, https:bool}, language:string[], db:array{core:array{masters:array{admin:array{db:string, database:string}, insert:array{db:string, database:string}, select:array{db:string, database:string}, update:array{db:string, database:string}, delete:array{db:string, database:string}, schema:array{db:string, database:string}}}}} $config Core config
     *
     * @throws \Exception
     *
     * @since 1.0.0
     */
    public function __construct(array $arg, array $config)
    {
        $this->appName = 'CLI';
        $this->config  = $config;
        $this->logger  = FileLogger::getInstance($config['log']['file']['path'], true);
    }

    /**
     * Setup general handlers for the application.
     *
     * @return void
     *
     * @since 1.0.0
     */
    private function setupHandlers() : void
    {
        \set_exception_handler(['\phpOMS\UnhandledHandler', 'exceptionHandler']);
        \set_error_handler(['\phpOMS\UnhandledHandler', 'errorHandler']);
        \register_shutdown_function(['\phpOMS\UnhandledHandler', 'shutdownHandler']);
        \mb_internal_encoding('UTF-8');

        $consoleSessionHandler = new FileSessionHandler(__DIR__);
        \session_set_save_handler($consoleSessionHandler);
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
        return $response;
    }
}
