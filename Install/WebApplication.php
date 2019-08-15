<?php
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package    Install
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       https://orange-management.org
 */
declare(strict_types=1);

namespace Install;

use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Dispatcher\Dispatcher;
use phpOMS\Localization\ISO639x1Enum;
use phpOMS\Localization\Localization;
use phpOMS\Log\FileLogger;
use phpOMS\Message\Http\Request;
use phpOMS\Message\Http\Response;
use phpOMS\Router\Router;
use phpOMS\Router\RouteVerb;
use phpOMS\System\MimeType;
use phpOMS\Uri\UriFactory;
use phpOMS\Views\View;

/**
 * Application class.
 *
 * @package    Install
 * @license    OMS License 1.0
 * @link       https://orange-management.org
 * @since      1.0.0
 */
final class WebApplication extends InstallAbstract
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
        $request      = $this->initRequest($config['page']['root'], $config['language'][0]);
        $response     = $this->initResponse($request, $config['language']);

        UriFactory::setupUriBuilder($request->getUri());

        $this->run($request, $response);

        /** @var \phpOMS\Message\Http\Header $header */
        $header = $response->getHeader();
        $header->push();

        echo $response->getBody();
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
        $response->getHeader()->set('content-type', 'text/html; charset=utf-8');
        $response->getHeader()->set('x-xss-protection', '1; mode=block');
        $response->getHeader()->set('x-content-type-options', 'nosniff');
        $response->getHeader()->set('x-frame-options', 'SAMEORIGIN');
        $response->getHeader()->set('referrer-policy', 'same-origin');

        if ($request->isHttps()) {
            $response->getHeader()->set('strict-transport-security', 'max-age=31536000');
        }

        $response->getHeader()->getL11n()->setLanguage(
            !\in_array($request->getHeader()->getL11n()->getLanguage(), $languages) ? 'en' : $request->getHeader()->getL11n()->getLanguage()
        );

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
    private function run(Request $request, Response $response) : void
    {
        $this->dispatcher = new Dispatcher($this);
        $this->router     = new Router();

        $this->setupRoutes();
        $response->getHeader()->set('content-language', $response->getHeader()->getL11n()->getLanguage(), true);
        UriFactory::setQuery('/lang', $response->getHeader()->getL11n()->getLanguage());

        $dispatched = $this->dispatcher->dispatch(
            $this->router->route(
                $request->getUri()->getRoute(),
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
     * @since  1.0.0
     */
    private function setupRoutes() : void
    {
        $this->router->add('^.*', '\Install\WebApplication::installView', RouteVerb::GET);
        $this->router->add('^.*', '\Install\WebApplication::installRequest', RouteVerb::PUT);
    }

    /**
     * Create install view
     *
     * @param Request  $request  Request
     * @param Response $response Response
     *
     * @return void
     *
     * @since  1.0.0
     */
    public static function installView(Request $request, Response $response) : void
    {
        $view = new View(null, $request, $response);
        $view->setTemplate('/Install/index');
        $response->set('Content', $view);
    }

    /**
     * Handle install request.
     *
     * @param Request  $request  Request
     * @param Response $response Response
     *
     * @return void
     *
     * @since  1.0.0
     */
    public static function installRequest(Request $request, Response $response) : void
    {
        $response->getHeader()->set('Content-Type', MimeType::M_JSON . '; charset=utf-8', true);

        if (!empty($valid = self::validateRequest($request))) {
            return;
        }

        $db = self::setupDatabaseConnection($request);
        DataMapperAbstract::setConnection($db);

        self::clearOld();
        self::installConfigFile($request);
        self::installCore($db);
        self::installGroups($db);
        self::installUsers($request, $db);
        self::installSettings($request, $db);
        self::configureCoreModules($request, $db);
    }

    /**
     * Validate install request.
     *
     * @param Request $request Request
     *
     * @return array<string, bool>
     *
     * @since  1.0.0
     */
    private static function validateRequest(Request $request) : array
    {
        $valid = [];

        if (($valid['php_extensions'] = !self::hasPhpExtensions())
            || ($valid['iDbHost'] = empty($request->getData('dbhost')))
            || ($valid['iDbType'] = empty($request->getData('dbtype')))
            || ($valid['iDbPort'] = empty($request->getData('dbport')))
            || ($valid['iDbPrefix'] = empty($request->getData('dbprefix')))
            || ($valid['iDbName'] = empty($request->getData('dbname')))
            || ($valid['iSchemaUser'] = empty($request->getData('schemauser')))
            //|| ($valid['iSchemaPassword'] = empty($request->getData('schemapassword')))
            || ($valid['iCreateUser'] = empty($request->getData('createuser')))
            //|| ($valid['iCreatePassword'] = empty($request->getData('createpassword')))
            || ($valid['iSelectUser'] = empty($request->getData('selectuser')))
            //|| ($valid['iSelectPassword'] = empty($request->getData('selectpassword')))
            || ($valid['iDeleteUser'] = empty($request->getData('deleteuser')))
            //|| ($valid['iDeletePassword'] = empty($request->getData('deletepassword')))
            || ($valid['iDbName'] = !self::testDbConnection($request))
            || ($valid['iOrgName'] = empty($request->getData('orgname')))
            || ($valid['iAdminName'] = empty($request->getData('adminname')))
            //|| ($valid['iAdminPassword'] = empty($request->getData('adminpassword')))
            || ($valid['iAdminEmail'] = empty($request->getData('adminemail')))
            || ($valid['iDomain'] = empty($request->getData('domain')))
            || ($valid['iWebSubdir'] = empty($request->getData('websubdir')))
            || ($valid['iDefaultLang'] = empty($request->getData('defaultlang')))
        ) {
            return $valid;
        }

        return [];
    }
}
