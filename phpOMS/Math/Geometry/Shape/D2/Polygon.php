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
     * Polygon perimeter.
     *
     * @var float
     * @since 1.0.0
     */
    private $perimeter = 0.0;

    /**
     * Polygon surface.
     *
     * @var float
     * @since 1.0.0
     */
    private $surface = 0.0;

    /**
     * Interior angle sum of the polygon.
     *
     * @var int
     * @since 1.0.0
     */
    private $interiorAngleSum = 0;

    /**
     * Exterior angle sum of the polygon.
     *
     * @var float
     * @since 1.0.0
     */
    private $exteriorAngleSum = 0.0;

    /**
     * Polygon barycenter.
     *
     * @var float[]
     * @since 1.0.0
     */
    private $barycenter = ['x' => 0.0, 'y' => 0.0];

    /**
     * Polygon edge length.
     *
     * @var float
     * @since 1.0.0
     */
    private $edgeLength = 0.0;

    /**
     * Polygon inner length.
     *
     * @var float
     * @since 1.0.0
     */
    private $innerLength = 0.0;

    /**
     * Polygon inner edge angular.
     *
     * @var int
     * @since 1.0.0
     */
    private $innerEdgeAngular = 0;

    /**
     * Constructor.
     *
     * @since  1.0.0
     */
    public function __construct()
    {
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
        return self::isPointInPolygon($point, $this->coord[] = $this->coord[0]);
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
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function onVertex(array $point) : bool
    {
        return self::isOnVertex($point, $this->coord);
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
     * Set polygon coordinates.
     *
     * @param array[] $coord Coordinates
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setCoordinates($coord) /* : void */
    {
        $this->coord = $coord;
    }

    /**
     * Set polygon coordinate.
     *
     * @param int       $i Index
     * @param int|float $x X coordinate
     * @param int|float $y Y coordinate
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setCoordinate($i, $x, $y) /* : void */
    {
        $this->coord[$i] = ['x' => $x, 'y' => $y];
    }

    /**
     * {@inheritdoc}
     */
    public function getInteriorAngleSum() : int
    {
        $this->interiorAngleSum = (count($this->coord) - 2) * 180;

        return $this->interiorAngleSum;
    }

    /**
     * {@inheritdoc}
     */
    public function getExteriorAngleSum()
    {
        return 360;
    }

    /**
     * {@inheritdoc}
     */
    public function getInteriorAngleSumFormula()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getExteriorAngleSumFormula()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getSurface() : float
    {
        return abs($this->getSignedSurface());
    }

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
     * {@inheritdoc}
     */
    public function setSurface($surface) /* : void */
    {
        $this->reset();

        $this->surface = $surface;
    }

    /**
     * {@inheritdoc}
     */
    public function reset() /* : void */
    {
        $this->coord            = [];
        $this->barycenter       = ['x' => 0.0, 'y' => 0.0];
        $this->perimeter        = 0.0;
        $this->surface          = 0.0;
        $this->interiorAngleSum = 0;
        $this->edgeLength       = 0.0;
        $this->innerLength      = 0.0;
        $this->innerEdgeAngular = 0;
    }

    /**
     * {@inheritdoc}
     */
    public function getSurfaceFormula()
    {
        return '';
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function setPerimeter($perimeter) /* : void */
    {
        $this->reset();

        $this->perimeter = $perimeter;
    }

    /**
     * {@inheritdoc}
     */
    public function getPerimeterFormula()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getBarycenter()
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
