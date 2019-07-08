<?php
/**
 * Orange Management
 *
 * PHP Version 7.2
 *
 * @package    Install
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       https://orange-management.org
 */
declare(strict_types=1);

namespace Install;

use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\Dispatcher\Dispatcher;
use phpOMS\Localization\Localization;
use phpOMS\Log\FileLogger;
use phpOMS\Message\Console\Request;
use phpOMS\Message\Console\Response;
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
final class ConsoleApplication extends InstallAbstract
{
    /**
     * Constructor.
     *
     * @param array $config Core config
     * @param array $arg    Call argument
     *
     * @since  1.0.0
     */
    public function __construct(array $config, array $arg)
    {
        if (PHP_SAPI !== 'cli') {
            throw new \Exception();
        }

        $this->setupHandlers();

        $this->logger = FileLogger::getInstance($config['log']['file']['path'], false);
        $request      = $this->initRequest($config['language'][0]);
        $response     = $this->initResponse($request);

        UriFactory::setupUriBuilder($request->getUri());

        $this->run($request, $response);

        echo $response->getBody();
    }

    /**
     * Initialize current application request
     *
     * @param string $language Fallback language
     *
     * @return Request Initial client request
     *
     * @since  1.0.0
     */
    private function initRequest(string $language) : Request
    {
        $request = new Request();

        $request->createRequestHashs(0);
        UriFactory::setupUriBuilder($request->getUri());

        $request->getHeader()->getL11n()->setLanguage($language);
        UriFactory::setQuery('/lang', $language);

        return $request;
    }

    /**
     * Initialize basic response
     *
     * @param Request $request Client request
     *
     * @return Response Initial client request
     *
     * @since  1.0.0
     */
    private function initResponse(Request $request) : Response
    {
        $response = new Response(new Localization());

        $response->getHeader()->getL11n()->setLanguage($request->getHeader()->getL11n()->getLanguage());

        return $response;
    }

    /**
     * Rendering install.
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
        if (!empty($valid = self::validateRequest($request))) {
            return;
        }

        $db = self::setupDatabaseConnection($request);

        self::clearOld();
        self::installConfigFile($request);
        self::installCore($db);
        self::installGroups($db);
        self::installUsers($request, $db);
        self::installSettings($request, $db);
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
