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
 namespace phpOMS\Math\Statistic\Forecast\Regression;

use phpOMS\Math\Matrix\Matrix;

class MultipleLinearRegression
{
    /**
     * {@inheritdoc}
     */
    public static function getRegression(array $x, array $y) : array
    {
        $X = new Matrix(count($x), count($x[0]));
        $X->setMatrix($x);
        $XT = $X->transpose();

        $Y = new Matrix(count($y));
        $Y->setMatrix($y);

        return $XT->mult($X)->inverse()->mult($XT)->mult($Y)->getMatrix();
    }

    /**
     * {@inheritdoc}
     */
    public static function getVariance() : float
    {
    }

    /**
     * {@inheritdoc}
     */
    public static function getPredictionInterval() : array
    {
    }
}