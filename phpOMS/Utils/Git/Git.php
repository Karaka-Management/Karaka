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

namespace phpOMS\Utils\Git;

use phpOMS\System\File\PathException;

/**
 * Gray encoding class
 *
 * @category   Framework
 * @package    phpOMS\Asset
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Git
{
    /**
     * Git path.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $bin = '/usr/bin/git';

    /**
     * Test git.
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public static function test() : bool
    {
        $pipes    = [];
        $resource = proc_open(escapeshellarg(Git::getBin()), [1 => ['pipe', 'w'], 2 => ['pipe', 'w']], $pipes);

        $stdout = stream_get_contents($pipes[1]);
        $stderr = stream_get_contents($pipes[2]);

        foreach ($pipes as $pipe) {
            fclose($pipe);
        }

        return trim(proc_close($resource)) !== 127;
    }

    /**
     * Get git binary.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public static function getBin() : string
    {
        return self::$bin;
    }

    /**
     * Set git binary.
     *
     * @param string $path Git path
     *
     * @throws PathException
     *
     * @since  1.0.0
     */
    public static function setBin(string $path) /* : void */
    {
        if (realpath($path) === false) {
            throw new PathException($path);
        }

        self::$bin = realpath($path);
    }
}
