<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   Model
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Model;

/**
 * General business and economic statistics class.
 *
 * @package phpOMS\Utils\Parser\Presentation
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
class GeneralStatistics
{
    public const _DEU = [
        'sick_time' => [
            'office' => 0,
            'outside' => 0,
            'gastronomy' => 0,
            'production' => 0,
            'logistics' => 0,
            'manager' => 0,
        ],
        'age' => 0,
        'affiliation' => 0,
        'salary' => [
            '...' => 0
        ],
        'revenue' => [
            '...' => 0
        ],
        'profit' => [
            '...' => 0
        ],
        'ebit' => [
            '...' => 0
        ],
        'hr_expenses' => [
            '...' => 0
        ],
        'marketing_expenses' => [
            '...' => 0
        ],
        'inflation' => 0,
        'interest_rate' => 0,
    ];
}
