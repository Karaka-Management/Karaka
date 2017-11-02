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

/**
 * TSP solution with brute force.
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class BruteForce
{
    /**
     * City limit (for factorial calculation).
     *
     * @var float
     * @since 1.0.0
     */
    /* public */ const LIMIT = 22;

    /**
     * City pool.
     *
     * @var CityPool
     * @since 1.0.0
     */
    private $cityPool = null;

    /**
     * Constructor.
     *
     * @param CityPool $pool City pool
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    public function __construct(CityPool $pool)
    {
        $this->cityPool = $pool;

        if ($this->cityPool->count() > self::LIMIT) {
            throw new \Exception('Overflow');
        }
    }

    /**
     * Calculate best routes.
     *
     * @param int $limit Amount of best routes
     *
     * @return Population
     *
     * @since  1.0.0
     */
    public function getSolution(int $limit = 1) : Population
    {
        $population = new Population($this->cityPool, $limit, true);
        $cities     = $this->cityPool->getCities();

        $this->bruteForce($cities, new Tour($this->cityPool, false), $population);

        return $population;
    }

    /**
     * Bruteforce best solutions.
     *
     * @param array      $cities     Cities
     * @param Tour       $tour       Current (potential) optimal tour
     * @param Population $population Population of tours
     *
     * @return Population
     *
     * @since  1.0.0
     */
    private function bruteForce(array $cities, Tour $tour, Population $population)
    {
        if (empty($cities)) {
            $population->addTour($tour);
        }

        $count = count($cities);
        for ($i = 0; $i < $count; $i++) {
            $extended = clone $tour;
            $extended->addCity($cities[$i]);
            unset($cities[$i]);

            if ($population->getUnfittest()->getFitness() > $extended->getFitness()) {
                continue;
            }

            $this->bruteForce($cities, $extended, $population);
        }
    }
}
