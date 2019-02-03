<?php
/**
 * Orange Management
 *
 * PHP Version 7.2
 *
 * @package    Web
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
declare(strict_types=1);

namespace Web;

use phpOMS\ApplicationAbstract;

use phpOMS\Autoloader;
use phpOMS\Localization\ISO639x1Enum;
use phpOMS\Localization\Localization;
use phpOMS\Log\FileLogger;
use phpOMS\Message\Http\Request;
use phpOMS\Message\Http\Response;
use phpOMS\Uri\UriFactory;

use Web\Exception\DatabaseException;
use Web\Exception\UnexpectedApplicationException;

/**
 * Application class.
 *
 * @package    Web
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class WebApplication extends ApplicationAbstract
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
        $response = null;
        $sub      = null;

        try {
            $this->setupHandlers();

            $this->logger = FileLogger::getInstance($config['log']['file']['path'], false);
            $request      = $this->initRequest($config['page']['root'], $config['language'][0]);
            $response     = $this->initResponse($request, $config['language']);

            UriFactory::setupUriBuilder($request->getUri());

            $applicationName = $this->getApplicationName($request->getUri()->getPathElement(1) ?? '');
            $app             = '\Web\\' . $applicationName . '\Application';
            $sub             = new $app($this, $config);
        } catch (DatabaseException $e) {
            $this->logger->critical(FileLogger::MSG_FULL, [
                'message' => $e->getMessage(),
                'line'    => __LINE__]);
            $sub = new \Web\E503\Application($this, $config);
        } catch (UnexpectedApplicationException $e) {
            $this->logger->critical(FileLogger::MSG_FULL, [
                'message' => $e->getMessage(),
                'line'    => __LINE__]);
            $sub = new \Web\E404\Application($this, $config);
        } catch (\Throwable $e) {
            $this->logger->critical(FileLogger::MSG_FULL, [
                'message' => $e->getMessage(),
                'line'    => __LINE__]);
            $sub = new \Web\E500\Application($this, $config);
        } finally {
            if ($sub === null) {
                $sub = new \Web\E500\Application($this, $config);
            }

            if ($response === null) {
                $response = new Response();
            }

            $sub->run($request ?? new Request(), $response);

            if ($this->sessionManager !== null) {
                $this->sessionManager->save();
            }

            /** @var \phpOMS\Message\Http\Header $header */
            $header = $response->getHeader();
            $header->push();

            if ($this->sessionManager !== null) {
                $this->sessionManager->lock();
            }

            echo $response->getBody();
        }
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
        $request->getHeader()->getL11n()->loadFromLanguage(
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

        $response->getHeader()->getL11n()->loadFromLanguage(
            !\in_array(
                $request->getHeader()->getL11n()->getLanguage(), $languages
            ) ? $languages[0] : $request->getHeader()->getL11n()->getLanguage()
        );

        return $response;
    }

    /**
     * Get name of the application.
     *
     * The application name will be evaluated based on the URI.
     *
     * @param string $request Request string of the current request
     *
     * @return string Application name
     *
     * @since  1.0.0
     */
    private function getApplicationName(string $request) : string
    {
        $applicationName = \ucfirst(\strtolower($request));
        $applicationName = empty($applicationName) ? 'E500' : $applicationName;

        if (Autoloader::exists('\Web\\' . $applicationName . '\Application') === false) {
            throw new UnexpectedApplicationException($applicationName);
        }

        return $applicationName;
    }
}
