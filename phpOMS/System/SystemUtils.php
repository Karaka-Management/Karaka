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
 * @link       http://website.orange-management.de
 */
declare(strict_types = 1);

namespace phpOMS\System;

/**
 * System utils
 *
 * @category   Framework
 * @package    phpOMS\System
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class SystemUtils
{

    /**
     * Constructor.
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    private function __construct()
    {
    }

    /**
     * Get system RAM.
     *
     * @return int
     *
     * @since  1.0.0
     */
    public static function getRAM() : int
    {
        $mem = 0;

        if (stristr(PHP_OS, 'WIN')) {
            $mem = null;
            exec('wmic memorychip get capacity', $mem);
            
            /** @var array $mem */
            $mem = array_sum($mem) / 1024;
        } elseif (stristr(PHP_OS, 'LINUX')) {
            $fh  = fopen('/proc/meminfo', 'r');
            $mem = 0;

            while ($line = fgets($fh)) {
                $pieces = [];
                if (preg_match('/^MemTotal:\s+(\d+)\skB$/', $line, $pieces)) {
                    $mem = $pieces[1] * 1024;
                    break;
                }
            }
            
            fclose($fh);
        }

        return (int) $mem;
    }

    /**
     * Get RAM usage.
     *
     * @return int
     *
     * @since  1.0.0
     */
    public static function getRAMUsage() : int
    {
        $memusage = 0;

        if (stristr(PHP_OS, 'LINUX')) {
            $free     = shell_exec('free');
            $free     = (string) trim($free);
            $free_arr = explode("\n", $free);
            $mem      = explode(" ", $free_arr[1]);
            $mem      = array_filter($mem);
            $mem      = array_merge($mem);
            $memusage = $mem[2] / $mem[1] * 100;
        }

        return (int) $memusage;
    }

    /**
     * Get cpu usage.
     *
     * @return int
     *
     * @since  1.0.0
     */
    public static function getCpuUsage() : int
    {
        $cpuusage = 0;

        if (stristr(PHP_OS, 'WIN') !== false) {
            $cpuusage = null;
            exec('wmic cpu get LoadPercentage', $cpuusage);
            $cpuusage = $cpuusage[1];
        } elseif (stristr(PHP_OS, 'LINUX') !== false) {
            $cpuusage = \sys_getloadavg()[0] * 100;
        }

        return (int) $cpuusage;
    }
}
