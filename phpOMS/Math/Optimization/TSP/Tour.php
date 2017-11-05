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

namespace phpOMS\Math\Optimization\TSP;

/**
 * Tour class.
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Tour implements \Countable
{
    /**
     * Cities
     *
     * @var City[]
     * @since 1.0.0
     */
    private $cities = [];

    /**
     * Tour fitness
     *
     * @var City[]
     * @since 1.0.0
     */
    private $fitness = 0.0;

    /**
     * Tour distance
     *
     * @var City[]
     * @since 1.0.0
     */
    private $distance = 0.0;

    /**
     * City pool
     *
     * @var CityPool
     * @since 1.0.0
     */
    private $cityPool = null;

    /**
     * Constructor.
     *
     * @param CityPool $pool       City pool
     * @param bool     $initialize Initialize with random tours
     *
     * @since  1.0.0
     */
    public function __construct(CityPool $pool, bool $initialize = false)
    {
        $this->cityPool = $pool;

        if ($initialize) {
            $this->cities = $this->cityPool->getCities();
            shuffle($this->cities);
        }
    }

    /**
     * Get city.
     *
     * @param int $index Index
     *
     * @return null|City
     *
     * @since  1.0.0
     */
    public function getCity($index)
    {
        return array_values($this->cities)[$index] ?? null;
    }

    /**
     * Get fitness.
     *
     * @return float
     *
     * @since  1.0.0
     */
    public function getFitness() : float
    {
        if ($this->fitness === 0.0 && ($distance = $this->getDistance()) !== 0.0) {
            $this->fitness = 1 / $distance;
        }

        return $this->fitness;
    }

    /**
     * Get tour distance
     *
     * @return float
     *
     * @since  1.0.0
     */
    public function getDistance() : float
    {
        if ($this->distance === 0.0) {
            $distance = 0.0;

            $count = count($this->cities);

            for ($i = 0; $i < $count; $i++) {
                $dest = ($i + 1 < $count) ? $this->cities[$i + 1] : $this->cities[0];

                $distance += $this->cities[$i]->getDistanceTo($dest);
            }

            $this->distance = $distance;
        }

        return $this->distance;
    }

    /**
     * Add city to tour.
     *
     * @param City $city City
     *
     * @since  1.0.0
     */
    public function addCity(City $city)
    {
        $this->cities[] = $city;

        $this->fitness  = 0.0;
        $this->distance = 0.0;
    }

    /**
     * Set city
     *
     * @param int  $index Index to set/replace
     * @param City $city  City
     *
     * @since  1.0.0
     */
    public function setCity(int $index, City $city) /* : void */
    {
        $this->cities[$index] = $city;
        asort($this->cities);

        $this->fitness  = 0.0;
        $this->distance = 0.0;
    }

    /**
     * Has city.
     *
     * @param City $city City
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function hasCity(City $city) : bool
    {
        foreach ($this->cities as $c) {
            if ($c->equals($city)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get city count
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function count() : int
    {
        return count($this->cities);
    }
}
