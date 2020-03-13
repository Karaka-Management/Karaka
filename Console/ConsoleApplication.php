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

use Model\CoreSettings;
use phpOMS\Account\AccountManager;
use phpOMS\Application\ApplicationAbstract;
use phpOMS\DataStorage\Cache\CachePool;
use phpOMS\DataStorage\Database\Connection\ConnectionAbstract;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\DataStorage\Session\ConsoleSession;
use phpOMS\DataStorage\Session\ConsoleSessionHandler;
use phpOMS\Dispatcher\Dispatcher;
use phpOMS\Event\EventManager;
use phpOMS\Localization\ISO639x1Enum;
use phpOMS\Localization\L11nManager;
use phpOMS\Localization\Localization;
use phpOMS\Log\FileLogger;
use phpOMS\Message\Console\ConsoleRequest;
use phpOMS\Message\Console\ConsoleResponse;
use phpOMS\Module\ModuleManager;
use phpOMS\Router\WebRouter;
use phpOMS\Uri\Argument;
use phpOMS\Uri\UriFactory;
use phpOMS\Views\View;

use Web\Exception\DatabaseException;

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
        $response      = null;

        $this->logger = FileLogger::getInstance($config['log']['file']['path'], true);

        try {
            if (\PHP_SAPI !== 'cli') {
                throw new \Exception();
            }

            //$this->setupHandlers();
            $request  = $this->initRequest($arg, $config['app']['path'], $config['language'][0]);
            $response = $this->initResponse($request, $config['language']);

            $this->dbPool = new DatabasePool();
            $this->dbPool->create('core', $this->config['db']['core']['masters']['admin']);
            $this->dbPool->create('insert', $this->config['db']['core']['masters']['insert']);
            $this->dbPool->create('select', $this->config['db']['core']['masters']['select']);
            $this->dbPool->create('update', $this->config['db']['core']['masters']['update']);
            $this->dbPool->create('delete', $this->config['db']['core']['masters']['delete']);
            $this->dbPool->create('schema', $this->config['db']['core']['masters']['schema']);

            /** @var ConnectionAbstract $con */
            $con = $this->dbPool->get();

            $this->l11nManager = new L11nManager($this->appName);
            $this->router      = new WebRouter();
            $this->router->importFromFile(__DIR__ . '/Routes.php');

            $this->cachePool      = new CachePool();
            $this->appSettings    = new CoreSettings($con);
            $this->eventManager   = new EventManager();
            $this->sessionManager = new ConsoleSession();
            $this->accountManager = new AccountManager($this->sessionManager);
            $this->moduleManager  = new ModuleManager($this, __DIR__ . '/../../Modules');
            $this->dispatcher     = new Dispatcher($this);

            $pageView = new View($this->l11nManager, $request, $response);
            $pageView->setTemplate('/Console/index');
            $response->set('Content', $pageView);

            $modules = $this->moduleManager->getActiveModules();
            $this->moduleManager->initModule($modules);

            $routed     = $this->router->route($request->getUri()->getRoute());
            $dispatched = $this->dispatcher->dispatch($routed, $request, $response);
            $pageView->addData('dispatch', $dispatched);
        } catch (DatabaseException $e) {
            $this->logger->critical(FileLogger::MSG_FULL, [
                'message' => $e->getMessage(),
                'line'    => 62, ]);

            $response ??= new ConsoleResponse();
            $response->set('Content', 'Database error: ' . $e->getMessage());
        } catch (\Throwable $e) {
            $this->logger->critical(FileLogger::MSG_FULL, [
                'message' => $e->getMessage(),
                'line'    => 66, ]);

            $response ??= new ConsoleResponse();
            $response->set('Content', 'Critical error: ' . $e->getMessage());
        } finally {
            $response ??= new ConsoleResponse();

            echo $response->getBody();
        }
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

        $consoleSessionHandler = new ConsoleSessionHandler(__DIR__);
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
        $request     = new ConsoleRequest(new Argument($arg[1] ?? ''));
        $subDirDepth = \substr_count($rootPath, '/');

        $request->createRequestHashs($subDirDepth);
        $request->getUri()->setRootPath($rootPath);
        UriFactory::setupUriBuilder($request->getUri());

        $langCode = \strtolower($request->getUri()->getPathElement(0));
        $request->getHeader()->getL11n()->loadFromLanguage(
            empty($langCode) || !ISO639x1Enum::isValidValue($langCode) ? $language : $langCode
        );
        UriFactory::setQuery('/lang', $request->getHeader()->getL11n()->getLanguage());

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

        $response->getHeader()->getL11n()->loadFromLanguage(
            !\in_array(
                $request->getHeader()->getL11n()->getLanguage(), $languages
            ) ? $languages[0] : $request->getHeader()->getL11n()->getLanguage()
        );

        return $response;
    }
}
