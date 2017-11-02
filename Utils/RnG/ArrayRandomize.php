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

namespace phpOMS\Utils\RnG;

/**
 * Array randomizer class
 *
 * @category   Framework
 * @package    phpOMS\Asset
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class ArrayRandomize
{
    /**
     * Yates array shuffler.
     *
     * @param array $arr Array to randomize
     *
     * @return array
     *
     * @since  1.0.0
     */
    public static function yates(array $arr) : array
    {
        $shuffled = [];

        while (!empty($arr)) {
            $rnd        = array_rand($arr);
            $shuffled[] = $arr[$rnd];
            array_splice($arr, $rnd, 1);
        }

        return $shuffled;
    }

    /**
     * Knuths array shuffler.
     *
     * @param array $arr Array to randomize
     *
     * @return array
     *
     * @since  1.0.0
     */
    public static function knuth(array $arr) : array
    {
        $shuffled = [];

        for ($i = count($arr) - 1; $i > 0; $i--) {
            $rnd            = mt_rand(0, $i);
            $shuffled[$i]   = $arr[$rnd];
            $shuffled[$rnd] = $arr[$i];
        }

        return $shuffled;
    }
}