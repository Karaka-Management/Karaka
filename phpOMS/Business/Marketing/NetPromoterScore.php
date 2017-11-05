<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   Framework
 * @package    phpOMS\Business\Marketing
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
declare(strict_types = 1);

namespace phpOMS\Business\Marketing;

/**
 * Net Promoter Score
 * 
 * The net promoter score is a basic evaluation of the happiness of customers. 
 * Instead of customers the NPS can also be transferred to non-customers.
 *
 * @category   Framework
 * @package    phpOMS\Business\Marketing
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class NetPromoterScore {
    /**
     * Score values
     *
     * @var int[]
     * @since 1.0.0
     */
    private $scores = [];

    /**
     * Constructor.
     *
     * @since  1.0.0
     */
    public function __construct() {

    }

    /**
     * Add score.
     *
     * @param int $score Net promoter score
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function add(int $score) /* : void */
    {
        $this->scores[] = $score;
    }

    /**
     * Get total NPS.
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function getScore() : int
    {
        $promoters  = 0;
        $passives   = 0;
        $detractors = 0;

        foreach ($this->scores as $score) {
            if ($score > 8) {
                $promoters++;
            } elseif ($score > 6) {
                $passives++;
            } else {
                $detractors++;
            }
        }

        $total = $promoters + $passives + $detractors;

        return $total === 0 ? 0 : ((int) ($promoters * 100 / $total)) - ((int) ($detractors * 100 / $total));
    }

    /**
     * Count detractors
     *
     * Detractors are all ratings below 7.
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function countDetractors() : int
    {
        $count = 0;
        foreach ($this->scores as $score) {
            if ($score < 7) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Count passives
     *
     * Passives are all ratings between 7 and 8 (inclusive)
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function countPassives() : int
    {
        $count = 0;
        foreach ($this->scores as $score) {
            if ($score > 6 && $score < 9) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Count promoters
     *
     * Promotoers are all ratings larger 8
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function countPromoters() : int
    {
        $count = 0;
        foreach ($this->scores as $score) {
            if ($score > 8) {
                $count++;
            }
        }

        return $count;
    }
}