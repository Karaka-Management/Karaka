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
 * @link       http://orange-management.com
 */
declare(strict_types = 1);

namespace phpOMS\Message\Http;

use phpOMS\Message\HeaderAbstract;
use phpOMS\DataStorage\LockException;

/**
 * Response class.
 *
 * @category   Framework
 * @package    phpOMS\Response
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Header extends HeaderAbstract
{

    /**
     * Header.
     *
     * @var string[][]
     * @since 1.0.0
     */
    private $header = [];

    /**
     * Constructor.
     *
     * @since  1.0.0
     */
    public function __construct()
    {
        $this->set('Content-Type', 'text/html; charset=utf-8');
        parent::__construct();
    }

    /**
     * Set header.
     *
     * @param string $key Header key (case insensitive)
     * @param string $header Header value
     * @param bool $overwrite Overwrite if already existing
     *
     * @return bool
     *
     * @throws LockException The http header needs to be defined at the beginning. If it is already pushed further interactions are impossible and locked.
     * @throws \Exception If the header already exists and cannot be overwritten this exception will be thrown.
     *
     * @todo Allow to extend header key with additional values.
     *
     * @since  1.0.0
     */
    public function set(string $key, string $header, bool $overwrite = false) : bool
    {
        if (self::$isLocked) {
            throw new LockException('HTTP header');
        }

        if (self::isSecurityHeader($key) && isset($this->header[$key])) {
            throw new \Exception('Cannot change security headers.');
        }

        $key = strtolower($key);

        if (!$overwrite && isset($this->header[$key])) {
            return false;
        }

        unset($this->header[$key]);

        if (!isset($this->header[$key])) {
            $this->header[$key] = [];
        }

        $this->header[$key][] = $header;

        return true;
    }
    
    /**
     * Is security header.
     *
     * @param string $key Header key
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public static function isSecurityHeader(string $key) : bool
    {
        $key = strtolower($key);

        return $key === 'content-security-policy'
            || $key === 'x-xss-protection'
            || $key === 'x-content-type-options'
            || $key === 'x-frame-options';
    }

    /**
     * {@inheritdoc}
     */
    public function getProtocolVersion() : string
    {
        return $_SERVER['SERVER_PROTOCOL'] ?? 'HTTP/1.1';
    }

    /**
     * Get status code.
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function getStatusCode() : int
    {
        if ($this->status === 0) {
            $this->status = (int) \http_response_code();
        }
        
        return parent::getStatusCode();
    }

    /**
     * Get all headers for apache and nginx
     *
     * @return array
     *
     * @since  1.0.0
     */
    public static function getAllHeaders() : array
    {
        if (function_exists('getallheaders')) {
            return getallheaders();
        }

        $headers = []; 
        foreach ($_SERVER as $name => $value) { 
            if (substr($name, 0, 5) == 'HTTP_') { 
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value; 
            } 
        } 

        return $headers;
    }

    /**
     * Remove header by ID.
     *
     * @param mixed $key Header key
     *
     * @return bool
     *
     * @throws LockException The http header needs to be defined at the beginning. If it is already pushed further interactions are impossible and locked.
     *
     * @since  1.0.0
     */
    public function remove($key) : bool
    {
        if (self::$isLocked) {
            throw new LockException('HTTP header');
        }

        if (isset($this->header[$key])) {
            unset($this->header[$key]);

            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getReasonPhrase() : string
    {
        $phrases = $this->get('Status');

        return empty($phrases) ? '' : $phrases[0];
    }

    /**
     * Get header by name.
     *
     * @param string $key Header key
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function get(string $key) : array
    {
        return $this->header[strtolower($key)] ?? [];
    }

    /**
     * Check if header is defined.
     *
     * @param string $key Header key
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function has(string $key) : bool
    {
        return isset($this->header[$key]);
    }

    /**
     * Push all headers.
     *
     * @since  1.0.0
     */
    public function push() /* : void */
    {
        if (self::$isLocked) {
            throw new \Exception('Already locked');
        }

        foreach ($this->header as $name => $arr) {
            foreach ($arr as $ele => $value) {
                header($name . ': ' . $value);
            }
        }

        header("X-Powered-By: hidden");

        $this->lock();
    }

    /**
     * {@inheritdoc}
     */
    public function generate(int $code) /* : void */
    {
        switch ($code) {
            case RequestStatusCode::R_403:
                $this->generate403();
                break;
            case RequestStatusCode::R_404:
                $this->generate404();
                break;
            case RequestStatusCode::R_406:
                $this->generate406();
                break;
            case RequestStatusCode::R_407:
                $this->generate407();
                break;
            case RequestStatusCode::R_503:
                $this->generate503();
                break;
            default:
                $this->generate500();
        }
    }

    /**
     * Generate predefined header.
     *
     * @return void
     *
     * @since  1.0.0
     */
    private function generate403() /* : void */
    {
        $this->set('HTTP', 'HTTP/1.0 403 Forbidden');
        $this->set('Status', 'Status: HTTP/1.0 403 Forbidden');
        \http_response_code(403);
    }

    /**
     * Generate predefined header.
     *
     * @return void
     *
     * @since  1.0.0
     */
    private function generate404() /* : void */
    {
        $this->set('HTTP', 'HTTP/1.0 404 Not Found');
        $this->set('Status', 'Status: HTTP/1.0 404 Not Found');
        \http_response_code(404);
    }

    /**
     * Generate predefined header.
     *
     * @return void
     *
     * @since  1.0.0
     */
    private function generate406() /* : void */
    {
        $this->set('HTTP', 'HTTP/1.0 406 Not acceptable');
        $this->set('Status', 'Status: 406 Not acceptable');
        \http_response_code(406);
    }

    /**
     * Generate predefined header.
     *
     * @return void
     *
     * @since  1.0.0
     */
    private function generate407() /* : void */
    {
        \http_response_code(407);
    }

    /**
     * Generate predefined header.
     *
     * @return void
     *
     * @since  1.0.0
     */
    private function generate503() /* : void */
    {
        $this->set('HTTP', 'HTTP/1.0 503 Service Temporarily Unavailable');
        $this->set('Status', 'Status: 503 Service Temporarily Unavailable');
        $this->set('Retry-After', 'Retry-After: 300');
        \http_response_code(503);
    }

    /**
     * Generate predefined header.
     *
     * @return void
     *
     * @since  1.0.0
     */
    private function generate500() /* : void */
    {
        $this->set('HTTP', 'HTTP/1.0 500 Internal Server Error');
        $this->set('Status', 'Status: 500 Internal Server Error');
        $this->set('Retry-After', 'Retry-After: 300');
        \http_response_code(500);
    }
}
