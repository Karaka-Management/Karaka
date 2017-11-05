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

namespace phpOMS\Math\Differential;

use phpOMS\Math\Parser\Evaluator;

/**
 * Chi square distribution.
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class FiniteDifference
{
    /**
     * Epsilon.
     *
     * @var float
     * @since 1.0.0
     */
    /* public */ const EPSILON = 0.00001;

    /**
     * Differentiate by using the Newton difference quotient.
     *
     * Example: ('2*x^3-4x', ['x' => 99])
     *
     * @param string $formula  Formula to differentiate
     * @param array  $variable Variable to differentiate (name value assiziation)
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getNewtonDifferenceQuotient(string $formula, array $variable) : float
    {
        return (Evaluator::evaluate($formula, ['x' => $variable['x'] + self::EPSILON]) - Evaluator::evaluate($formula, ['x' => $variable['x']])) / self::EPSILON;
    }

    /**
     * Differentiate by using the symmetric difference quotient.
     *
     * Example: ('2*x^3-4x', ['x' => 99])
     *
     * @param string $formula  Formula to differentiate
     * @param array  $variable Variable to differentiate (name value assiziation)
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function getSymmetricDifferenceQuotient(string $formula, array $variable) : float
    {
        return (Evaluator::evaluate($formula, ['x' => $variable['x'] + self::EPSILON]) - Evaluator::evaluate($formula, ['x' => $variable['x'] - self::EPSILON])) / (2 * self::EPSILON);
    }

    /**
     * Differentiate by using the five point stencil.
     *
     * Example: ('2*x^3-4x', ['x' => 99], 3)
     *
     * @param string $formula    Formula to differentiate
     * @param array  $variable   Variable to differentiate (name value assiziation)
     * @param int    $derivative Derivative (4th = highest)
     *
     * @return float
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    public static function getFivePointStencil(string $formula, array $variable, int $derivative = 1) : float
    {
        if ($derivative === 1) {
            return (-Evaluator::evaluate($formula, ['x' => $variable['x'] + 2 * self::EPSILON]) + 8 * Evaluator::evaluate($formula, ['x' => $variable['x'] + self::EPSILON]) - 8 * Evaluator::evaluate($formula, ['x' => $variable['x'] - self::EPSILON]) + Evaluator::evaluate($formula, ['x' => $variable['x'] - 2 * self::EPSILON])) / (12 * self::EPSILON);
        } elseif ($derivative === 2) {
            return (-Evaluator::evaluate($formula, ['x' => $variable['x'] + 2 * self::EPSILON]) + 16 * Evaluator::evaluate($formula, ['x' => $variable['x'] + self::EPSILON]) - 30 * Evaluator::evaluate($formula, ['x' => $variable['x']]) + 16 * Evaluator::evaluate($formula, ['x' => $variable['x'] - self::EPSILON]) - Evaluator::evaluate($formula, ['x' => $variable['x'] - 2 * self::EPSILON])) / (12 * self::EPSILON ** 2);
        } elseif ($derivative === 3) {
            return (Evaluator::evaluate($formula, ['x' => $variable['x'] + 2 * self::EPSILON]) - 2 * Evaluator::evaluate($formula, ['x' => $variable['x'] + self::EPSILON]) + 2 * Evaluator::evaluate($formula, ['x' => $variable['x'] - self::EPSILON]) - Evaluator::evaluate($formula, ['x' => $variable['x'] - 2 * self::EPSILON])) / (2 * self::EPSILON ** 3);
        } elseif ($derivative === 4) {
            return (Evaluator::evaluate($formula, ['x' => $variable['x'] + 2 * self::EPSILON]) - 4 * Evaluator::evaluate($formula, ['x' => $variable['x'] + self::EPSILON]) + 6 * Evaluator::evaluate($formula, ['x' => $variable['x']]) - 4 * Evaluator::evaluate($formula, ['x' => $variable['x'] - self::EPSILON]) + Evaluator::evaluate($formula, ['x' => $variable['x'] - 2 * self::EPSILON])) / (self::EPSILON ** 4);
        }

        throw new \Exception('Derivative too high');
    }
}
