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

namespace phpOMS\DataStorage\Session;

/**
 * Session interface.
 *
 * Sessions can be used by http requests, console interaction and socket connections
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Cache
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
interface SessionInterface
{

    /**
     * Get session variable by key.
     *
     * @param string|int $key Value key
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public function get($key);

    /**
     * Store session value by key.
     *
     * @param string|int $key       Value key
     * @param mixed      $value     Value to store
     * @param bool       $overwrite Overwrite existing values
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function set($key, $value, bool $overwrite = true) : bool;

    /**
     * Remove value from session by key.
     *
     * @param string|int $key Value key
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function remove($key) : bool;

    /**
     * Save session.
     *
     * @todo   : implement save type (session, cache, database)
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function save() /* : void */;

    /**
     * @return int|string
     *
     * @since  1.0.0
     */
    public function getSID();

    /**
     * @param int|string $sid
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setSID($sid) /* : void */;

}
