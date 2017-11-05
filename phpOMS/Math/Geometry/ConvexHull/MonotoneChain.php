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

namespace phpOMS\Math\Geometry\ConvexHull;

/**
 * Andrew's monotone chain convex hull algorithm class.
 *
 * @category   Framework
 * @package    phpOMS\Utils\TaskSchedule
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 *
 * @todo       : implement vertice class or use vertice class used by graphs? May be usefull in order to give vertices IDs!
 */
final class MonotoneChain
{
    /**
     * Create convex hull
     *
     * @param array $points Points (Point Cloud)
     *
     * @return array
     *
     * @since  1.0.0
     */
    public static function createConvexHull(array $points) : array
    {
        if (($n = count($points)) > 1) {
            uasort($points, [self::class, 'sort']);

            $k = 0;
            $result = [];

            // Lower hull
            for ($i = 0; $i < $n; ++$i) {
                while ($k >= 2 && self::cross($result[$k - 2], $result[$k - 1], $points[$i]) <= 0) {
                    $k--;
                }

                $result[$k++] = $points[$i];
            }

            // Upper hull
            for ($i = $n - 2, $t = $k + 1; $i >= 0; $i--) {
                while ($k >= $t && self::cross($result[$k - 2], $result[$k - 1], $points[$i]) <= 0) {
                    $k--;
                }

                $result[$k++] = $points[$i];
            }

            ksort($result);

            return array_slice($result, 0, $k - 1);
        }

        return $points;
    }

    /**
     * Counter clock wise turn?
     *
     * @param array $a Point a
     * @param array $b Point b
     * @param array $c Point c
     *
     * @return float
     *
     * @since  1.0.0
     */
    private static function cross(array $a, array $b, array $c) : float
    {
        return ($b['x'] - $a['x']) * ($c['y'] - $a['y']) - ($b['y'] - $a['y']) * ($c['x'] - $a['x']);
    }

    /**
     * Sort by x coordinate then by z coordinate
     *
     * @param array $a Point a
     * @param array $b Point b
     *
     * @return float
     *
     * @since  1.0.0
     */
    private static function sort(array $a, array $b) : float
    {
        return $a['x'] === $b['x'] ? $a['y'] - $b['y'] : $a['x'] - $b['x'];
    }
}