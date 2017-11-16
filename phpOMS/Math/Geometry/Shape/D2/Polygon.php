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

namespace phpOMS\Math\Geometry\Shape\D2;

/**
 * Polygon class.
 *
 * @category   Framework
 * @package    phpOMS\Math
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Polygon implements D2ShapeInterface
{
    /**
     * Epsilon for float comparison.
     *
     * @var float
     * @since 1.0.0
     */
    /* public */ const EPSILON = 0.00001;

    /**
     * Coordinates.
     *
     * These coordinates define the polygon
     *
     * @var array[]
     * @since 1.0.0
     */
    private $coord = [];

    /**
     * Constructor.
     *
     * @since  1.0.0
     */
    public function __construct(array $coord)
    {
        $this->coord = $coord;
    }

    /**
     * Point polygon relative position
     *
     * @param array $point Point location
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function pointInPolygon(array $point) : int
    {
        $coord = $this->coord;
        $coord[] = $this->coord[0];
        return self::isPointInPolygon($point, $coord);
    }

    /**
     * Point polygon relative position
     *
     * @param array $point Point location
     * @param array $polygon Polygon definition
     *
     * @return int -1 inside polygon 0 on vertice 1 outside
     * 
     * @link http://erich.realtimerendering.com/ptinpoly/
     * @since  1.0.0
     */
    public static function isPointInPolygon(array $point, array $polygon) : int
    {
        $length = count($polygon);

        // Polygon has to start and end with same point
        if ($polygon[0]['x'] !== $polygon[$length - 1]['x'] || $polygon[0]['y'] !== $polygon[$length - 1]['y']) {
            $polygon[] = $polygon[0];
        }

        // On vertex?
        if (self::isOnVertex($point, $polygon)) {
            return 0;
        }

        // Inside or ontop?
        $countIntersect = 0;
        $polygon_count = count($polygon);

        // todo: return based on highest possibility not by first match
        for ($i = 1; $i < $polygon_count; $i++) {
            $vertex1 = $polygon[$i - 1];
            $vertex2 = $polygon[$i];

            if (abs($vertex1['y'] - $vertex2['y']) < self::EPSILON && abs($vertex1['y'] - $point['y']) < self::EPSILON && $point['x'] > min($vertex1['x'], $vertex2['x']) && $point['x'] < max($vertex1['x'], $vertex2['x'])) {
                return 0; // boundary
            }

            if ($point['y'] > min($vertex1['y'], $vertex2['y']) && $point['y'] <= max($vertex1['y'], $vertex2['y']) && $point['x'] <= max($vertex1['x'], $vertex2['x']) && abs($vertex1['y'] - $vertex2['y']) >= self::EPSILON) {
                $xinters = ($point['y'] - $vertex1['y']) * ($vertex2['x'] - $vertex1['x']) / ($vertex2['y'] - $vertex1['y']) + $vertex1['x'];

                if (abs($xinters - $point['x']) < self::EPSILON) {
                    return 0; // boundary
                }

                if (abs($vertex1['x'] - $vertex2['x']) < self::EPSILON || $point['x'] < $xinters) {
                    $countIntersect++;
                }
            }
        }

        if ($countIntersect % 2 !== 0) {
            return -1;
        }

        return 1;
    }

    /**
     * Is point on vertex?
     *
     * @param array $point Point location
     * @param array $polygon Polygon definition
     *
     * @return bool
     *
     * @since  1.0.0
     */
    private static function isOnVertex(array $point, array $polygon) : bool
    {
        foreach ($polygon as $vertex) {
            if (abs($point['x'] - $vertex['x']) < self::EPSILON && abs($point['y'] - $vertex['y']) < self::EPSILON) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get interior angle sum
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function getInteriorAngleSum() : int
    {
        return (count($this->coord) - 2) * 180;
    }

    /**
     * Get exterior angle sum
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function getExteriorAngleSum()
    {
        return 360;
    }

    /**
     * Get surface area
     *
     * @return float
     *
     * @since  1.0.0
     */
    public function getSurface() : float
    {
        return abs($this->getSignedSurface());
    }

    /**
     * Get signed surface area
     *
     * @return float
     *
     * @since  1.0.0
     */
    private function getSignedSurface() : float
    {
        $count = count($this->coord);
        $surface = 0;

        for ($i = 0; $i < $count - 1; $i++) {
            $surface += $this->coord[$i]['x'] * $this->coord[$i + 1]['y'] - $this->coord[$i + 1]['x'] * $this->coord[$i]['y'];
        }

        $surface += $this->coord[$count - 1]['x'] * $this->coord[0]['y'] - $this->coord[0]['x'] * $this->coord[$count - 1]['y'];

        $surface /= 2;

        return $surface;
    }

    /**
     * Get perimeter
     *
     * @return float
     *
     * @since  1.0.0
     */
    public function getPerimeter() : float
    {
        $count           = count($this->coord);
        $this->perimeter = sqrt(($this->coord[0]['x'] - $this->coord[$count - 1]['x']) ** 2 + ($this->coord[0]['y'] - $this->coord[$count - 1]['y']) ** 2);

        for ($i = 0; $i < $count - 1; $i++) {
            $this->perimeter += sqrt(($this->coord[$i + 1]['x'] - $this->coord[$i]['x']) ** 2 + ($this->coord[$i + 1]['y'] - $this->coord[$i]['y']) ** 2);
        }

        return $this->perimeter;
    }

    /**
     * Get barycenter
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function getBarycenter() : array
    {
        $this->barycenter['x'] = 0;
        $this->barycenter['y'] = 0;

        $count = count($this->coord);

        for ($i = 0; $i < $count - 1; $i++) {
            $mult = ($this->coord[$i]['x'] * $this->coord[$i + 1]['y'] - $this->coord[$i + 1]['x'] * $this->coord[$i]['y']);
            $this->barycenter['x'] += ($this->coord[$i]['x'] + $this->coord[$i + 1]['x']) * $mult;
            $this->barycenter['y'] += ($this->coord[$i]['y'] + $this->coord[$i + 1]['y']) * $mult;
        }

        $mult = ($this->coord[$count - 1]['x'] * $this->coord[0]['y'] - $this->coord[0]['x'] * $this->coord[$count - 1]['y']);
        $this->barycenter['x'] += ($this->coord[$count - 1]['x'] + $this->coord[0]['x']) * $mult;
        $this->barycenter['y'] += ($this->coord[$count - 1]['y'] + $this->coord[0]['y']) * $mult;

        $surface = $this->getSignedSurface();

        $this->barycenter['x'] = 1 / (6 * $surface) * $this->barycenter['x'];
        $this->barycenter['y'] = 1 / (6 * $surface) * $this->barycenter['y'];

        return $this->barycenter;
    }
}
