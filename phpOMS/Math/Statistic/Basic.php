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

namespace phpOMS\Math\Statistic;

/**
 * Basic statistic functions.
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Basic
{

    /**
     * Calculate frequency.
     *
     * Example: ([4, 5, 9, 1, 3])
     *
     * @param array $values Values
     *
     * @return array
     *
     * @since  1.0.0
     */
    public static function freaquency(array $values) : array
    {
        $freaquency = [];
        $sum = 1;

        if (!($isArray = is_array(reset($values)))) {
            $sum = array_sum($values);
        }

        foreach ($values as $value) {
            if ($isArray) {
                $freaquency[] = self::freaquency($value);
            } else {
                $freaquency[] = $value / $sum;
            }
        }

        return $freaquency;
    }
}
