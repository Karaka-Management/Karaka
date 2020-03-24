<?php
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package   Web
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Web;

use phpOMS\Application\ApplicationAbstract;
use phpOMS\Autoloader;
use phpOMS\Localization\ISO639x1Enum;
use phpOMS\Localization\Localization;
use phpOMS\Log\FileLogger;
use phpOMS\Message\Http\HttpRequest;
use phpOMS\Message\Http\HttpResponse;
use phpOMS\Uri\HttpUri;
use phpOMS\Uri\UriFactory;

use Web\Exception\DatabaseException;
use Web\Exception\UnexpectedApplicationException;

/**
 * Application class.
 *
 * @package Web
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 *
 * @todo Ornage-Management/phpOMS#202
 *  Dynamic string handling
 *  Implement a parsing system which allows to output dynamic strings (sprintf might help)
 *
 * @todo Orange-Management/Modules#98
 *  Add unit id to all models
 *  All models are bound to a specific unit or 0/null in case of no unit.
 *  This is important since not everyone should be allowed to create models for all units (unless permissions say so).
 */
class WebApplication extends ApplicationAbstract
{
    /**
     * Constructor.
     *
     * @param array{log:array{file:array{path:string}}, app:array{path:string, default:array{id:string, app:string, org:int, lang:string}, domains:array}, page:array{root:string, https:bool}, language:string[]} $config Core config
     *
     * @since 1.0.0
     */
    public function __construct(array $config)
    {
        $response = null;
        $sub      = null;

        try {
            $this->setupHandlers();

            $this->logger = FileLogger::getInstance($config['log']['file']['path'], false);

            UriFactory::setQuery('/prefix', '');
            UriFactory::setQuery('/api', 'api/');
            $applicationName = $this->getApplicationName(HttpUri::fromCurrent(), $config['app']);
            $request         = $this->initRequest($config['page']['root'], $config['app']);
            $response        = $this->initResponse($request, $config);

            $this->theme = $this->getApplicationTheme($request, $config['app']['domains']);

            $app = '\Web\\' . $applicationName . '\Application';
            $sub = new $app($this, $config);
        } catch (DatabaseException $e) {
            $this->logger->critical(FileLogger::MSG_FULL, [
                'message' => $e->getMessage(),
                'line'    => __LINE__, ]);
            $sub = new \Web\E503\Application($this, $config);
        } catch (UnexpectedApplicationException $e) {
            $this->logger->critical(FileLogger::MSG_FULL, [
                'message' => $e->getMessage(),
                'line'    => __LINE__, ]);
            $sub = new \Web\E404\Application($this, $config);
        } catch (\Throwable $e) {
            $this->logger->critical(FileLogger::MSG_FULL, [
                'message' => $e->getMessage(),
                'line'    => __LINE__, ]);
            $sub = new \Web\E500\Application($this, $config);
        } finally {
            if ($sub === null) {
                $sub = new \Web\E500\Application($this, $config);
            }

            if ($response === null) {
                $response = new HttpResponse();
            }

            $sub->run($request ?? new HttpRequest(), $response);

            if (isset($this->sessionManager)) {
                $this->sessionManager->save();
            }

            $response->getHeader()->push();

            if (isset($this->sessionManager)) {
                $this->sessionManager->lock();
            }

            echo $response->getBody(true);
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
//        \set_exception_handler(['\phpOMS\UnhandledHandler', 'exceptionHandler']);
//        \set_error_handler(['\phpOMS\UnhandledHandler', 'errorHandler']);
//        \register_shutdown_function(['\phpOMS\UnhandledHandler', 'shutdownHandler']);
//        \mb_internal_encoding('UTF-8');
    }

    /**
     * Initialize current application request
     *
     * @param string                                                                           $rootPath Web root path
     * @param array{domains:array, default:array{id:string, app:string, org:int, lang:string}} $config   App config
     *
     * @return HttpRequest Initial client request
     *
     * @since 1.0.0
     */
    private function initRequest(string $rootPath, array $config) : HttpRequest
    {
        $request     = HttpRequest::createFromSuperglobals();
        $subDirDepth = \substr_count($rootPath, '/') - 1;

        $defaultLang = $config['domains'][$request->getUri()->getHost()]['lang'] ?? $config['default']['lang'];
        $uriLang     = \strtolower($request->getUri()->getPathElement($subDirDepth + 0));
        $requestLang = $request->getRequestLanguage();
        $langCode    = ISO639x1Enum::isValidValue($uriLang) ? $uriLang : (ISO639x1Enum::isValidValue($requestLang) ? $requestLang : $defaultLang);

        $pathOffset = $subDirDepth
            + (ISO639x1Enum::isValidValue($uriLang) ?
                1 + ($this->getApplicationNameFromString($request->getUri()->getPathElement($subDirDepth + 1)) !== 'E500' ? 1 : 0) :
                0 + ($this->getApplicationNameFromString($request->getUri()->getPathElement($subDirDepth + 0)) !== 'E500' ? 1 : 0)
        );

        $request->createRequestHashs($pathOffset);
        $request->getUri()->setRootPath($rootPath);
        $request->getUri()->setPathOffset($pathOffset);
        UriFactory::setupUriBuilder($request->getUri());

        $request->getHeader()->getL11n()->loadFromLanguage($langCode, \explode('_', $request->getLocale())[1] ?? '*');

        return $request;
    }

    /**
     * Initialize basic response
     *
     * @param HttpRequest                                                                                                    $request Client request
     * @param array{app:array{domains:array, default:array{id:string, app:string, org:int, lang:string}}, language:string[]} $config  App config
     *
     * @return HttpResponse Initial client request
     *
     * @since 1.0.0
     */
    private function initResponse(HttpRequest $request, array $config) : HttpResponse
    {
        $response = new HttpResponse(new Localization());
        $response->getHeader()->set('content-type', 'text/html; charset=utf-8');
        $response->getHeader()->set('x-xss-protection', '1; mode=block');
        $response->getHeader()->set('x-content-type-options', 'nosniff');
        $response->getHeader()->set('x-frame-options', 'SAMEORIGIN');
        $response->getHeader()->set('referrer-policy', 'same-origin');

        if ($request->isHttps()) {
            $response->getHeader()->set('strict-transport-security', 'max-age=31536000');
        }

        $defaultLang = $config['app']['domains'][$request->getUri()->getHost()]['lang'] ?? $config['app']['default']['lang'];
        $uriLang     = \strtolower($request->getUri()->getPathElement(0));
        $requestLang = $request->getHeader()->getL11n()->getLanguage();
        $langCode    = ISO639x1Enum::isValidValue($requestLang) && \in_array($requestLang, $config['language'])
            ? $requestLang
            : (ISO639x1Enum::isValidValue($uriLang) && \in_array($uriLang, $config['language'])
                ? $uriLang
                : $defaultLang
            );

        $response->getHeader()->getL11n()->loadFromLanguage($langCode, \explode('_', $request->getLocale())[1] ?? '*');
        UriFactory::setQuery('/lang', $request->getHeader()->getL11n()->getLanguage());

        if (ISO639x1Enum::isValidValue($uriLang)) {
            UriFactory::setQuery('/prefix',  $uriLang . '/' . (empty(UriFactory::getQuery('/prefix')) ? '' : UriFactory::getQuery('/prefix')));
            UriFactory::setQuery('/api',  $uriLang . '/' . (empty(UriFactory::getQuery('/api')) ? '' : UriFactory::getQuery('/api')));
        }

        return $response;
    }

    /**
     * Get name of the application.
     *
     * @param HttpUri                                                                          $uri    Current Uri
     * @param array{domains:array, default:array{id:string, app:string, org:int, lang:string}} $config App configuration
     *
     * @return string Application name
     *
     * @since 1.0.0
     */
    private function getApplicationName(HttpUri $uri, array $config) : string
    {
        // check subdomain
        $appName = $uri->getSubdomain();
        $appName = $this->getApplicationNameFromString($appName);

        if ($appName !== 'E500') {
            return $appName;
        }

        // check uri path 0 (no language is defined)
        $appName = $uri->getPathElement(0);
        $appName = $this->getApplicationNameFromString($appName);

        if ($appName !== 'E500') {
            UriFactory::setQuery('/prefix', (empty(UriFactory::getQuery('/prefix')) ? '' : UriFactory::getQuery('/prefix') . '/') . $uri->getPathElement(1) . '/');

            return $appName;
        }

        // check uri path 1 (language is defined)
        if (ISO639x1Enum::isValidValue($uri->getPathElement(0))) {
            $appName = $uri->getPathElement(1);
            $appName = $this->getApplicationNameFromString($appName);

            if ($appName !== 'E500') {
                UriFactory::setQuery('/prefix', (empty(UriFactory::getQuery('/prefix')) ? '' : UriFactory::getQuery('/prefix') . '/') . $uri->getPathElement(1) . '/');

                return $appName;
            }
        }

        // check config
        $appName = $config['domains'][$uri->getHost()]['app'] ?? $config['default']['app'];

        return $this->getApplicationNameFromString($appName);
    }

    /**
     * Get name of the application.
     *
     * @param string $app Application name proposal
     *
     * @return string Application name
     *
     * @since 1.0.0
     */
    private function getApplicationNameFromString(string $app) : string
    {
        $applicationName = \ucfirst(\strtolower($app));

        if (empty($applicationName) || !Autoloader::exists('\\Web\\' . $applicationName . '\\Application')) {
            $applicationName = 'E500';
        }

        return $applicationName;
    }

    /**
     * Get application theme
     *
     * @param HttpRequest $request Client request
     * @param array       $config  App config
     *
     * @return string Theme name
     *
     * @since 1.0.0
     */
    private function getApplicationTheme(HttpRequest $request, array $config) : string
    {
        return $config[$request->getUri()->getHost()]['theme'] ?? 'Backend';
    }
}
