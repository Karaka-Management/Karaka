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

namespace phpOMS\Math\Parser;

/**
 * Shape interface.
 *
 * @category   Framework
 * @package    phpOMS\Math
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Evaluator
{
    /**
     * Evaluate function.
     *
     * Example: ('2*x^3-4x', ['x' => 99])
     *
     * @param string $formula Formula to differentiate
     * @param array  $vars    Variables to evaluate
     *
     * @return float
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    public static function evaluate(string $formula, array $vars) : float
    {
        // todo: do i need array_values here?
        $formula = str_replace(array_keys($vars), array_values($vars), $formula);

        // todo: this is horrible in case things like mod etc. need to be supported
        if (preg_match('#[^0-9\+\-\*\/\(\)]#', $formula)) {
            throw new \Exception('Bad elements');
        }

        // todo: create parser

        return 0;
    }
}
