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

namespace phpOMS\Uri;

/**
 * Uri interface.
 *
 * @category   Framework
 * @package    phpOMS/Uri
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
interface UriInterface
{

    /**
     * Is uri valid?
     *
     * @param string $uri Uri string
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public static function isValid(string $uri) : bool;

    /**
     * Get scheme.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getScheme() : string;

    /**
     * Get authority.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getAuthority() : string;

    /**
     * Get user info.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getUserInfo() : string;

    /**
     * Get host.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getHost() : string;

    /**
     * Get port.
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function getPort() : int;

    /**
     * Get path.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getPath() : string;

    /**
     * Get path element.
     *
     * @param int $pos Position of the path
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getPathElement(int $pos) : string;

    /**
     * Get path elements.
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function getPathElements() : array;

    /**
     * Get query.
     *
     * @param string $key Query key
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getQuery(string $key = null) : string;

    /**
     * Get fragment.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getFragment() : string;

    /**
     * Get uri.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function __toString();

    /**
     * Get base uri.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getBase() : string;

    /**
     * Get route representation of uri.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getRoute() : string;

    /**
     * Set uri.
     *
     * @param string $uri Uri
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function set(string $uri);
}
