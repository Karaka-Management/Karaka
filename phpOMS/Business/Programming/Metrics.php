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

namespace phpOMS\Business\Programming;

/**
 * Programming metrics
 * 
 * This class provides basic programming metric calculations.
 *
 * @category   Framework
 * @package    phpOMS\Business
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Metrics {
    /**
     * Calculate ABC metric score
     *
     * @latex  r = \sqrt{a^{2} + b^{2} + c^{2}}
     *
     * @param int $a Assignments
     * @param int $b Branches
     * @param int $c Conditionals
     *
     * @return int
     *
     * @since  1.0.0
     */
    public static function abcScore(int $a, int $b, int $c) : int
    {
        return (int) sqrt($a * $a + $b * $b + $c * $c);
    }

    /**
     * Calculate the C.R.A.P score
     *
     * @latex  r = com^{2} \times (1 - cov)^{3} + com
     *
     * @param int $complexity Complexity
     * @param int $coverage Coverage
     *
     * @return int
     *
     * @since  1.0.0
     */
    public static function CRAP(int $complexity, float $coverage) : int
    {
        return (int) ($complexity ** 2 * (1 - $coverage) ** 3 + $complexity);
    }
}