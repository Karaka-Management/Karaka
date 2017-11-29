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
 * @link       http://website.orange-management.de
 */
declare(strict_types = 1);

namespace Install;

use phpOMS\ApplicationAbstract;

use phpOMS\Log\FileLogger;
use phpOMS\Message\Http\Request;
use phpOMS\Message\Http\Response;
use phpOMS\Localization\ISO639x1Enum;
use phpOMS\Localization\Localization;
use phpOMS\Uri\UriFactory;
use phpOMS\Router\Router;
use phpOMS\Router\RouteVerb;
use phpOMS\DataStorage\Database\DatabaseStatus;
use phpOMS\Message\Http\RequestMethod;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\Dispatcher\Dispatcher;
use phpOMS\Localization\L11nManager;
use phpOMS\Views\View;
use phpOMS\Autoloader;

/**
 * Application class.
 *
 * @category   Framework
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Application extends ApplicationAbstract
{

    /**
     * Constructor.
     *
     * @param array $config Core config
     *
     * @since  1.0.0
     */
    public function __construct(array $config)
    {
        $this->setupHandlers();

        $this->logger = FileLogger::getInstance($config['log']['file']['path'], false);
        $this->config = $config;
        $request      = $this->initRequest($config['page']['root'], $config['language'][0]);
        $response     = $this->initResponse($request, $config['language']);

        UriFactory::setupUriBuilder($request->getUri());

        $this->run($request, $response);
        $response->getHeader()->push();

        echo $response->getBody();
    }

    /**
     * Setup general handlers for the application.
     *
     * @return void
     *
     * @since  1.0.0
     */
    private function setupHandlers() /* : void */
    {
        set_exception_handler(['\phpOMS\UnhandledHandler', 'exceptionHandler']);
        set_error_handler(['\phpOMS\UnhandledHandler', 'errorHandler']);
        register_shutdown_function(['\phpOMS\UnhandledHandler', 'shutdownHandler']);
    }

    /**
     * Initialize current application request
     *
     * @param string $rootPath Web root path
     * @param string $language Fallback language
     *
     * @return Request Initial client request
     *
     * @since  1.0.0
     */
    private function initRequest(string $rootPath, string $language) : Request
    {
        $request     = Request::createFromSuperglobals();
        $subDirDepth = substr_count($rootPath, '/');

        $request->createRequestHashs($subDirDepth);
        $request->getUri()->setRootPath($rootPath);
        UriFactory::setupUriBuilder($request->getUri());

        $langCode = strtolower($request->getUri()->getPathElement(0));
        $request->getHeader()->getL11n()->setLanguage(
            empty($langCode) || !ISO639x1Enum::isValidValue($langCode) ? $language : $langCode
        );
        UriFactory::setQuery('/lang', $request->getHeader()->getL11n()->getLanguage());

        return $request;
    }

    /**
     * Initialize basic response
     *
     * @param Request $request Client request
     * @param array $languages Supported languages
     *
     * @return Response Initial client request
     *
     * @since  1.0.0
     */
    private function initResponse(Request $request, array $languages) : Response
    {
        $response = new Response(new Localization());
        $response->getHeader()->set('content-type', 'text/html; charset=utf-8');
        $response->getHeader()->set('x-xss-protection', '1; mode=block');
        $response->getHeader()->set('x-content-type-options', 'nosniff');
        $response->getHeader()->set('x-frame-options', 'SAMEORIGIN');
        $response->getHeader()->set('referrer-policy', 'same-origin');

        if ($request->isHttps()) {
            $response->getHeader()->set('strict-transport-security', 'max-age=31536000');
        }

        $response->getHeader()->getL11n()->setLanguage(!in_array($request->getHeader()->getL11n()->getLanguage(), $languages) ? 'en' : $request->getHeader()->getL11n()->getLanguage());

        return $response;
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
    private function run(Request $request, Response $response) /* : void */
    {
        $this->dbPool = new DatabasePool();
        $this->dispatcher = new Dispatcher($this);
        $this->router = new Router();

        $this->setupRoutes();

        $this->dbPool->create('admin', $this->config['db']['core']['masters']['admin']);
        DataMapperAbstract::setConnection($this->dbPool->get());

        $response->getHeader()->set('content-language', $response->getHeader()->getL11n()->getLanguage(), true);
        UriFactory::setQuery('/lang', $response->getHeader()->getL11n()->getLanguage());

        $this->dispatcher->dispatch($this->router->route($request), $request, $response);
    }

    private function setupRoutes()
    {
        $this->router->add('^.*', '\Install\Application::installView', RouteVerb::GET);
        $this->router->add('^.*', '\Install\Application::installRequest', RouteVerb::PUT);
    }

    public static function installView(Request $request, Response $response)
    {
        $view = new View(null, $request, $response);
        $view->setTemplate('/Install/index');
        $response->set('Content', $view);
    }

    public static function installRequest(Request $request, Response $response)
    {

    }
}