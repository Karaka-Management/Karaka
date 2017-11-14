<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   Framework
 * @package    phpOMS\Business\Finance\Forecasting\ExponentialSmoothing
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 * @see        https://www.otexts.org/fpp/7/7
 */
declare(strict_types = 1);

namespace phpOMS\Business\Finance\Forecasting\ExponentialSmoothing;

use phpOMS\Business\Finance\Forecasting\SmoothingType;
use phpOMS\Math\Statistic\Average;
use phpOMS\Math\Statistic\Forecast\Error;

class ExponentialSmoothing
{
    private $data = [];

    private $errors = [];

    private $rmse = 0.0;

    private $mse = 0.0;

    private $mae = 0.0;

    private $sse = 0.0;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getANN()
    {
    }

    public function getANA()
    {
    }

    public function getANM()
    {
    }

    public function getAAN()
    {
    }

    public function getAAA()
    {
    }

    public function getAAM()
    {
    }

    public function getAMN()
    {
    }

    public function getAMA()
    {
    }

    public function getAMM()
    {
    }

    public function getMNN()
    {
    }

    public function getMNA()
    {
    }

    public function getMNM()
    {
    }

    public function getMAN()
    {
    }

    public function getMAA()
    {
    }

    public function getMAM()
    {
    }

    public function getMMN()
    {
    }

    public function getMMA()
    {
    }

    public function getMMM()
    {
    }

}