<?php
/**
 * Orange Management
 *
 * PHP Version 7.2
 *
 * @package    Console
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://orange-management.com
 */
namespace Console;

use Model\CoreSettings;
use phpOMS\ApplicationAbstract;
use phpOMS\Console\CommandManager;
use phpOMS\Account\AccountManager;
use phpOMS\DataStorage\Cache\CachePool;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\DataStorage\Session\ConsoleSession;
use phpOMS\Dispatcher\Dispatcher;
use phpOMS\Event\EventManager;
use phpOMS\Localization\Localization;
use phpOMS\Localization\ISO639x1Enum;
use phpOMS\Localization\L11nManager;
use phpOMS\DataStorage\Database\Connection\ConnectionAbstract;
use phpOMS\Log\FileLogger;
use phpOMS\Module\ModuleManager;
use phpOMS\Router\Router;
use phpOMS\Message\Console\Request;
use phpOMS\Message\Console\Response;
use phpOMS\Uri\Argument;
use phpOMS\Uri\UriFactory;

/**
 * Application class.
 *
 * @package    Console
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class ConsoleApplication extends ApplicationAbstract
{
    /**
     * Temp config.
     *
     * @var array
     * @since 1.0.0
     */
    private $config = [];

    /**
     * Constructor.
     *
     * @param array $arg    Call argument
     * @param array $config Core config
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    public function __construct(array $arg, array $config)
    {
        if (PHP_SAPI !== 'cli') {
            throw new \Exception();
        }

        //$this->setupHandlers();

        $this->appName = 'CLI';
        $this->config  = $config;
        $this->logger  = FileLogger::getInstance($config['log']['file']['path'], true);
        $request       = $this->initRequest($arg, $config['app']['path'], $config['language'][0]);
        $response      = $this->initResponse($request, $config['language']);

        $this->dbPool = new DatabasePool();
        $this->dbPool->create('core', $this->config['db']['core']['masters']['admin']);

        /** @var ConnectionAbstract $con */
        $con = $this->dbPool->get();

        $this->l11nManager = new L11nManager();
        $this->router      = new Router();
        $this->router->importFromFile(__DIR__ . '/Routes.php');

        $this->cachePool      = new CachePool();
        $this->appSettings    = new CoreSettings($con);
        $this->eventManager   = new EventManager();
        $this->sessionManager = new ConsoleSession();
        $this->accountManager = new AccountManager($this->sessionManager);
        $this->moduleManager  = new ModuleManager($this, __DIR__ . '/../../Modules');
        $this->dispatcher     = new Dispatcher($this);
        $commandManager       = new CommandManager();

        $modules = $this->moduleManager->getActiveModules();
        $this->moduleManager->initModule($modules);

        $commandManager->attach('', function ($para) {
            echo "\n" , 'Useage: -h for help.', "\n\n";
        }, null);

        $commandManager->attach('-h', function ($para) {
            echo "\n" ,
                'For a list of commands for a specific module type: ' , "\033[0;31m/help/{MODULE_NAME}\033[0m" , "\n\n";
        }, null);

        $commandManager->trigger($arg[1] ?? '', $arg);
    }

    /**
     * Setup general handlers for the application.
     *
     * @return void
     *
     * @since  1.0.0
     */
    private function setupHandlers() : void
    {
        \set_exception_handler(['\phpOMS\UnhandledHandler', 'exceptionHandler']);
        \set_error_handler(['\phpOMS\UnhandledHandler', 'errorHandler']);
        \register_shutdown_function(['\phpOMS\UnhandledHandler', 'shutdownHandler']);
        \mb_internal_encoding('UTF-8');
    }

    /**
     * Initialize current application request
     *
     * @param array  $arg      Cli arguments
     * @param string $rootPath Web root path
     * @param string $language Fallback language
     *
     * @return Request Initial client request
     *
     * @since  1.0.0
     */
    private function initRequest(array $arg, string $rootPath, string $language) : Request
    {
        $request     = new Request(new Argument(\implode(' ', $arg)));
        $subDirDepth = \substr_count($rootPath, '/');

        $request->createRequestHashs($subDirDepth);
        $request->getUri()->setRootPath($rootPath);
        UriFactory::setupUriBuilder($request->getUri());

        $langCode = \strtolower($request->getUri()->getPathElement(0));
        $request->getHeader()->getL11n()->setLanguage(
            empty($langCode) || !ISO639x1Enum::isValidValue($langCode) ? $language : $langCode
        );
        UriFactory::setQuery('/lang', $request->getHeader()->getL11n()->getLanguage());

        return $request;
    }

    /**
     * Initialize basic response
     *
     * @param Request $request   Client request
     * @param array   $languages Supported languages
     *
     * @return Response Initial client request
     *
     * @since  1.0.0
     */
    private function initResponse(Request $request, array $languages) : Response
    {
        $response = new Response(new Localization());

        $response->getHeader()->getL11n()->setLanguage(
            !\in_array(
                $request->getHeader()->getL11n()->getLanguage(), $languages
            ) ? 'en' : $request->getHeader()->getL11n()->getLanguage()
        );

        return $response;
    }
}
