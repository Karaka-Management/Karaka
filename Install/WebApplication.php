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

use phpOMS\DataStorage\Database\DatabaseStatus;
use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;
use phpOMS\Dispatcher\Dispatcher;
use phpOMS\Localization\ISO639x1Enum;
use phpOMS\Localization\Localization;
use phpOMS\Log\FileLogger;
use phpOMS\Message\Http\HttpRequest;
use phpOMS\Message\Http\HttpResponse;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Router\RouteVerb;
use phpOMS\Router\WebRouter;
use phpOMS\System\MimeType;
use phpOMS\Uri\UriFactory;
use phpOMS\Views\View;

/**
 * Application class.
 *
 * @package Install
 * @license OMS License 1.0
 * @link    https://jingga.app
 * @since   1.0.0
 *
 * @property \phpOMS\Router\WebRouter $router
 */
final class WebApplication extends InstallAbstract
{
    /**
     * Constructor.
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        $this->setupHandlers();

        if (!\is_dir(__DIR__ . '/../Logs')) {
            \mkdir(__DIR__ . '/../Logs');
        }

        $this->logger = FileLogger::getInstance(__DIR__ . '/../Logs', false);
        $request      = $this->initRequest();
        $response     = $this->initResponse($request, ['en', 'de']);

        UriFactory::setupUriBuilder($request->uri);

        $this->run($request, $response);

        $response->header->push();
        echo $response->getBody();
    }

    /**
     * Initialize current application request
     *
     * @return HttpRequest Initial client request
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    private function initRequest() : HttpRequest
    {
        $request = HttpRequest::createFromSuperglobals();

        $rootPath = $request->uri->getPath();
        $offset   = \strripos($rootPath, '/');
        $rootPath = \substr($rootPath, -$offset);

        $subDirDepth = \substr_count($rootPath, '/');

        $request->createRequestHashs($subDirDepth);
        $request->uri->setRootPath($rootPath);
        UriFactory::setupUriBuilder($request->uri);

        $langCode = \strtolower($request->uri->getPathElement(0));
        $request->header->l11n->setLanguage(
            empty($langCode) || !ISO639x1Enum::isValidValue($langCode) ? 'en' : $langCode
        );
        UriFactory::setQuery('/lang', $request->getLanguage());

        return $request;
    }

    /**
     * Initialize basic response
     *
     * @param HttpRequest $request   Client request
     * @param array       $languages Supported languages
     *
     * @return HttpResponse Initial client request
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    private function initResponse(HttpRequest $request, array $languages) : HttpResponse
    {
        $response = new HttpResponse(new Localization());
        $response->header->set('content-type', 'text/html; charset=utf-8');
        $response->header->set('x-xss-protection', '1; mode=block');
        $response->header->set('x-content-type-options', 'nosniff');
        $response->header->set('x-frame-options', 'SAMEORIGIN');
        $response->header->set('referrer-policy', 'same-origin');

        if ($request->isHttps()) {
            $response->header->set('strict-transport-security', 'max-age=31536000');
        }

        $response->header->l11n->setLanguage(
            !\in_array($request->getLanguage(), $languages) ? 'en' : $request->getLanguage()
        );

        return $response;
    }

    /**
     * Rendering backend.
     *
     * @param HttpRequest  $request  Request
     * @param HttpResponse $response Response
     *
     * @return void
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    private function run(HttpRequest $request, HttpResponse $response) : void
    {
        $this->dispatcher = new Dispatcher($this);
        $this->router     = new WebRouter();

        $this->setupRoutes();
        $response->header->set('content-language', $response->getLanguage(), true);
        UriFactory::setQuery('/lang', $response->getLanguage());

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
     * @codeCoverageIgnore
     */
    private function setupRoutes() : void
    {
        $this->router->add('^.*', '\Install\WebApplication::installView', RouteVerb::GET);
        $this->router->add('^.*', '\Install\WebApplication::installRequest', RouteVerb::PUT);
    }

    /**
     * Create install view
     *
     * @param HttpRequest  $request  Request
     * @param HttpResponse $response Response
     *
     * @return void
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public static function installView(HttpRequest $request, HttpResponse $response) : void
    {
        $view = new View(null, $request, $response);
        $view->setTemplate('/Install/index');
        $response->set('Content', $view);
    }

    /**
     * Handle install request.
     *
     * @param HttpRequest  $request  Request
     * @param HttpResponse $response Response
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public static function installRequest(HttpRequest $request, HttpResponse $response) : void
    {
        $response->header->set('Content-Type', MimeType::M_JSON . '; charset=utf-8', true);

        if (!empty(self::validateRequest($request))) {
            $response->header->status = RequestStatusCode::R_400;
            return;
        }

        $db = self::setupDatabaseConnection($request);
        $db->connect();

        if ($db->getStatus() !== DatabaseStatus::OK) {
            $response->header->status = RequestStatusCode::R_400;
            return;
        }

        DataMapperFactory::db($db);

        self::clearOld();
        self::installConfigFile($request);
        self::installCore($db);
        self::installGroups();
        self::installUsers($request, $db);
        self::installWebApplications($request, $db);
        self::installLocalApplications($request, $db);
        self::installCoreModules($db);
        self::configureCoreModules($request, $db);

        $response->header->status = RequestStatusCode::R_200;
    }

    /**
     * Validate install request.
     *
     * @param HttpRequest $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private static function validateRequest(HttpRequest $request) : array
    {
        $valid = [];

        if (($valid['php_extensions'] = !self::hasPhpExtensions())
            || ($valid['iDbHost'] = empty($request->getData('dbhost')))
            || ($valid['iDbType'] = empty($request->getData('dbtype')))
            || ($valid['iDbPort'] = empty($request->getData('dbport')))
            || ($valid['iDbName'] = empty($request->getData('dbname')))
            || ($valid['iSchemaUser'] = empty($request->getData('schemauser')))
            //|| ($valid['iSchemaPassword'] = empty($request->getData('schemapassword')))
            || ($valid['iCreateUser'] = empty($request->getData('createuser')))
            //|| ($valid['iCreatePassword'] = empty($request->getData('createpassword')))
            || ($valid['iSelectUser'] = empty($request->getData('selectuser')))
            //|| ($valid['iSelectPassword'] = empty($request->getData('selectpassword')))
            || ($valid['iDeleteUser'] = empty($request->getData('deleteuser')))
            //|| ($valid['iDeletePassword'] = empty($request->getData('deletepassword')))
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
