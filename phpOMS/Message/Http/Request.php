<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   Framework
 * @package    phpOMS\Message\Http
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
declare(strict_types = 1);

namespace phpOMS\Message\Http;

use phpOMS\Localization\Localization;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\RequestSource;
use phpOMS\Router\RouteVerb;
use phpOMS\Uri\Http;
use phpOMS\Uri\UriFactory;
use phpOMS\Uri\UriInterface;

/**
 * Request class.
 *
 * @category   Framework
 * @package    phpOMS\Message\Http
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Request extends RequestAbstract
{

    /**
     * Uploaded files.
     *
     * @var array
     * @since 1.0.0
     */
    protected $files = [];
    /**
     * Browser type.
     *
     * @var string
     * @since 1.0.0
     */
    private $browser = BrowserType::CHROME;
    /**
     * OS type.
     *
     * @var string
     * @since 1.0.0
     */
    private $os = OSType::LINUX;
    /**
     * Request information.
     *
     * @var string[]
     * @since 1.0.0
     */
    private $info = null;

    /**
     * Constructor.
     *
     * @param UriInterface $uri  Uri
     * @param Localization $l11n Localization
     *
     * @since  1.0.0
     */
    public function __construct(UriInterface $uri = null, Localization $l11n = null)
    {
        $this->header = new Header();
        $this->header->setL11n($l11n ?? new Localization());

        $this->uri    = $uri;
        $this->source = RequestSource::WEB;

        $this->init();
    }

    /**
     * Init request.
     *
     * This is used in order to either initialize the current http request or a batch of GET requests
     *
     * @param void
     *
     * @return void
     *
     * @since  1.0.0
     */
    private function init() /* : void */
    {
        if (!isset($this->uri)) {
            $this->initCurrentRequest();
            $this->lock();
            $this->cleanupGlobals();
        }

        $this->data = array_change_key_case($this->data, CASE_LOWER);

        $this->setupUriBuilder();
    }

    /**
     * Init current request
     *
     * @return void
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    private function initCurrentRequest() /* : void */
    {
        $this->uri      = new Http(Http::getCurrent());
        $this->data     = $_GET ?? [];
        $this->files    = $_FILES ?? [];
        $this->header->getL11n()->setLanguage($this->loadRequestLanguage());

        if (isset($_SERVER['CONTENT_TYPE'])) {
            if (strpos($_SERVER['CONTENT_TYPE'], 'application/json') !== false) {
                if (($json = json_decode(($input = file_get_contents('php://input')), true)) === false || $json === null) {
                    throw new \Exception('Is not valid json ' . $input);
                }

                $this->data += $json;
            } elseif (strpos($_SERVER['CONTENT_TYPE'], 'application/x-www-form-urlencoded') !== false) {
                parse_str(file_get_contents('php://input'), $temp);
                $this->data += $temp;
            }
        }

        $this->uri = $this->uri ?? new Http(Http::getCurrent());
    }

    /**
     * Load request language
     *
     * @return string
     *
     * @since  1.0.0
     */
    private function loadRequestLanguage() : string
    {
        if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            return 'EN';
        }

        $lang = explode(';', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        $lang = explode('-', $lang[0]);

        return $lang[0];
    }

    /**
     * Clean up globals that musn't be used any longer
     *
     * @return void
     *
     * @since  1.0.0
     */
    private function cleanupGlobals() /* : void */
    {
        unset($_FILES);
        unset($_GET);
        unset($_POST);
        unset($_REQUEST);
    }

    /**
     * Setup uri builder based on current request
     *
     * @return void
     *
     * @since  1.0.0
     */
    private function setupUriBuilder() /* : void */
    {
        UriFactory::setQuery('/lang', $this->header->getL11n()->getLanguage());

        // todo: flush previous
        foreach ($this->data as $key => $value) {
            UriFactory::setQuery('?' . $key, $value);
        }
    }

    /**
     * Create request from super globals.
     *
     * @return Request
     *
     * @since  1.0.0
     */
    public static function createFromSuperglobals() : Request
    {
        return new self();
    }

    /**
     * {@inheritdoc}
     */
    public function setUri(UriInterface $uri) /* : void */
    {
        parent::setUri($uri);
        $this->data += $uri->getQueryArray();
    }

    /**
     * Create request hashs of current request
     *
     * The hashes are based on the request path and can be used as unique id.
     *
     * @param int $start Start hash from n-th path element
     *
     * @return void
     *
     * @todo: maybe change to normal path string e.g. /some/path/here instead of hash! Remember to adjust navigation elements
     *
     * @since  1.0.0
     */
    public function createRequestHashs(int $start = 0) /* : void */
    {
        $this->hash = [];
        $pathArray = $this->uri->getPathElements();
        
        foreach ($pathArray as $key => $path) {
            $paths = [];
            for ($i = $start; $i < $key + 1; $i++) {
                $paths[] = $pathArray[$i];
            }

            $this->hash[] = sha1(implode('', $paths));
        }
    }

    /**
     * Is Mobile
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function isMobile() : bool
    {
        // TODO: maybe replace this with smart media queries... checked gets handled in reverse!!!
        $useragent = $_SERVER['HTTP_USER_AGENT'] ?? '';

        if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', $useragent)) {
            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getRequestInfo() : array
    {
        if (!isset($this->info)) {
            $this->info['browser'] = $this->getBrowser();
            $this->info['os']      = $this->getOS();
        }

        return $this->info;
    }

    /**
     * Determine request browser.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getBrowser() : string
    {
        if (!isset($this->browser)) {
            $arr               = BrowserType::getConstants();
            $http_request_type = strtolower($_SERVER['HTTP_USER_AGENT']);

            foreach ($arr as $key => $val) {
                if (stripos($http_request_type, $val)) {
                    $this->browser = $val;
                    break;
                }
            }
        }

        return $this->browser;
    }

    /**
     * Set browser type
     *
     * @param string $browser Browser type
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setBrowser(string $browser) /* : void */
    {
        $this->browser = $browser;
    }

    /**
     * Determine request OS.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getOS() : string
    {
        if (!isset($this->os)) {
            $arr               = OSType::getConstants();
            $http_request_type = strtolower($_SERVER['HTTP_USER_AGENT']);
            
            foreach ($arr as $key => $val) {
                if (stripos($http_request_type, $val)) {
                    $this->os = $val;
                    break;
                }
            }
        }

        return $this->os;
    }

    /**
     * Set OS type
     *
     * @param string $os OS type
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setOS(string $os) /* : void */
    {
        $this->os = $os;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrigin() : string
    {
        return $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    }

    /**
     * Is request made via https.
     *
     * @param int $port Secure port
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function isHttps(int $port = 443) : bool
    {
        if ($port < 1 || $port > 65535) {
            throw new \OutOfRangeException('Value "' . $port . '" is out of range.');
        }

        return
            (!empty($_SERVER['HTTPS'] ?? '') && ($_SERVER['HTTPS'] ?? '') !== 'off')
            || (($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https')
            || (($_SERVER['HTTP_X_FORWARDED_SSL'] ?? '') === 'on')
            || ($_SERVER['SERVER_PORT'] ?? '') == $port;
    }

    /**
     * {@inheritdoc}
     */
    public function getBody() : string
    {
        return file_get_contents('php://input');
    }

    /**
     * {@inheritdoc}
     */
    public function getRequestTarget() : string
    {
        return '/';
    }

    /**
     * Get files passed in request.
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function getFiles() : array
    {
        return $this->files;
    }

    /**
     * Get route verb for this request.
     *
     * @return int
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    public function getRouteVerb() : int
    {
        switch ($this->getMethod()) {
            case RequestMethod::GET:
                return RouteVerb::GET;
            case RequestMethod::PUT:
                return RouteVerb::PUT;
            case RequestMethod::POST:
                return RouteVerb::SET;
            case RequestMethod::DELETE:
                return RouteVerb::DELETE;
            default:
                throw new \Exception();
        }
    }

    /**
     * Get request type.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getMethod() : string
    {
        if (!isset($this->method)) {
            $this->method = $_SERVER['REQUEST_METHOD'] ?? RequestMethod::GET;
        }

        return $this->method;
    }
}
