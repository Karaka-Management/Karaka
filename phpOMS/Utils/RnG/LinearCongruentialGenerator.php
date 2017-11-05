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

namespace phpOMS\Utils\RnG;

/**
 * Linear congruential generator class
 *
 * @category   Framework
 * @package    phpOMS\Asset
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class LinearCongruentialGenerator
{
    private static $bsdSeed = 0;
    private static $msvcrtSeed = 0;

    /**
     * BSD random number
     *
     * @param int $seed Starting seed
     *
     * @return \Closure
     *
     * @since  1.0.0
     */
    public static function bsd(int $seed = 0)
    {
        if ($seed !== 0) {
            self::$bsdSeed = $seed;
        }

        return self::$bsdSeed = (1103515245 * self::$bsdSeed + 12345) % (1 << 31);
    }

    /**
     * MS random number
     *
     * @param int $seed Starting seed
     *
     * @return \Closure
     *
     * @since  1.0.0
     */
    public static function msvcrt(int $seed = 0)
    {
        if ($seed !== 0) {
            self::$msvcrtSeed = $seed;
        }

        return (self::$msvcrtSeed = (214013 * self::$msvcrtSeed + 2531011) % (1 << 31)) >> 16;
    }
}
