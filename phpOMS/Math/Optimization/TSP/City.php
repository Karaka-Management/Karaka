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

namespace phpOMS\Math\Optimization\TSP;

use phpOMS\Math\Geometry\Shape\D3\Sphere;

/**
 * City class.
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class City
{
    /**
     * City name
     *
     * @var string
     * @since 1.0.0
     */
    private $name = '';

    /**
     * City longitude
     *
     * @var float
     * @since 1.0.0
     */
    private $long = 0.0;

    /**
     * City latitude
     *
     * @var float
     * @since 1.0.0
     */
    private $lat = 0.0;

    /**
     * Constructor.
     *
     * @param float  $lat  Latitude
     * @param float  $long Longitude
     * @param string $name City name
     *
     * @since  1.0.0
     */
    public function __construct(float $lat = 0, float $long = 0, string $name = '')
    {
        $this->long = $long;
        $this->lat  = $lat;
        $this->name = $name;
    }

    /**
     * Is equals to.
     *
     * @param City $city City
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function equals(City $city) : bool
    {
        return $this->name === $city->getName() && $this->lat === $city->getLatitude() && $this->long === $city->getLatitude();
    }

    /**
     * Get name.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Get latitude.
     *
     * @return float
     *
     * @since  1.0.0
     */
    public function getLatitude() : float
    {
        return $this->lat;
    }

    /**
     * Distance to city in meter
     *
     * @param City $city City
     *
     * @return float
     *
     * @since  1.0.0
     */
    public function getDistanceTo(City $city) : float
    {
        return Sphere::distance2PointsOnSphere($this->lat, $this->long, $city->getLatitude(), $city->getLongitude());
    }

    /**
     * Get longitude.
     *
     * @return float
     *
     * @since  1.0.0
     */
    public function getLongitude() : float
    {
        return $this->long;
    }
}
