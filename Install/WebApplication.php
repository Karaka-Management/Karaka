<?php

/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Install
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
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
 * @license OMS License 2.0
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
        UriFactory::setQuery('/lang', $request->header->l11n->language);

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
        $response->header->set('Content-Type', 'text/html; charset=utf-8');
        $response->header->set('x-xss-protection', '1; mode=block');
        $response->header->set('x-content-type-options', 'nosniff');
        $response->header->set('x-frame-options', 'SAMEORIGIN');
        $response->header->set('referrer-policy', 'same-origin');

        if ($request->isHttps()) {
            $response->header->set('strict-transport-security', 'max-age=31536000');
        }

        $response->header->l11n->language = \in_array($request->header->l11n->language, $languages)
            ? $request->header->l11n->language
            : 'en';

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
        $response->header->set('content-language', $response->header->l11n->language, true);
        UriFactory::setQuery('/lang', $response->header->l11n->language);

        $this->dispatcher->dispatch(
            $this->router->route(
                $request->uri->getRoute(),
                $request->getDataString('CSRF'),
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
            || ($valid['iDbHost'] = !$request->hasData('dbhost'))
            || ($valid['iDbType'] = !$request->hasData('dbtype'))
            || ($valid['iDbPort'] = !$request->hasData('dbport'))
            || ($valid['iDbName'] = !$request->hasData('dbname'))
            || ($valid['iSchemaUser'] = !$request->hasData('schemauser'))
            //|| ($valid['iSchemaPassword'] = !$request->hasData('schemapassword'))
            || ($valid['iCreateUser'] = !$request->hasData('createuser'))
            //|| ($valid['iCreatePassword'] = !$request->hasData('createpassword'))
            || ($valid['iSelectUser'] = !$request->hasData('selectuser'))
            //|| ($valid['iSelectPassword'] = !$request->hasData('selectpassword'))
            || ($valid['iDeleteUser'] = !$request->hasData('deleteuser'))
            //|| ($valid['iDeletePassword'] = !$request->hasData('deletepassword'))
            || ($valid['iOrgName'] = !$request->hasData('orgname'))
            || ($valid['iAdminName'] = !$request->hasData('adminname'))
            //|| ($valid['iAdminPassword'] = !$request->hasData('adminpassword'))
            || ($valid['iAdminEmail'] = !$request->hasData('adminemail'))
            || ($valid['iDomain'] = !$request->hasData('domain'))
            || ($valid['iWebSubdir'] = !$request->hasData('websubdir'))
            || ($valid['iDefaultLang'] = !$request->hasData('defaultlang'))
        ) {
            return $valid;
        }

        return [];
    }
}
