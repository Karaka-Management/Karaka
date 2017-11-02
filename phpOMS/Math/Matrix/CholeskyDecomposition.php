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

namespace phpOMS\Math\Matrix;

class CholeskyDecomposition
{
    private $L = [];

    private $m = 0;

    private $isSpd = true;

    public function __construct(Matrix $M)
    {
        $this->L = $M->toArray();
        $this->m = $M->getM();

        for ($i = 0; $i < $this->m; ++$i) {
            for ($j = $i; $j < $this->m; ++$j) {
                for ($sum = $this->L[$i][$j], $k = $i - 1; $k >= 0; --$k) {
                    $sum -= $this->L[$i][$k] * $this->L[$j][$k];
                }
                if ($i == $j) {
                    if ($sum >= 0) {
                        $this->L[$i][$i] = sqrt($sum);
                    } else {
                        $this->isSpd = false;
                    }
                } else {
                    if ($this->L[$i][$i] != 0) {
                        $this->L[$j][$i] = $sum / $this->L[$i][$i];
                    }
                }
            }

            for ($k = $i + 1; $k < $this->m; ++$k) {
                $this->L[$i][$k] = 0.0;
            }
        }
    }

    public function isSpd()
    {
        return $this->isSpd;
    }

    public function getL()
    {
        $matrix = new Matrix();
        $matrix->setMatrix($this->L);

        return $matrix;
    }

    public function solve(Matrix $B) 
    {
        if ($B->getM() !== $this->m) {
            // invalid dimension
        }

        if (!$this->isSpd) {
            // is not positive definite
        }

        $X  = $B->toArray();
        $nx = $B->getN();

        for ($k = 0; $k < $this->m; ++$k) {
            for ($i = $k + 1; $i < $this->m; ++$i) {
                for ($j = 0; $j < $nx; ++$j) {
                    $X[$i][$j] -= $X[$k][$j] * $this->L[$i][$k];
                }
            }
            for ($j = 0; $j < $nx; ++$j) {
                $X[$k][$j] /= $this->L[$k][$k];
            }
        }

        for ($k = $this->m - 1; $k >= 0; --$k) {
            for ($j = 0; $j < $nx; ++$j) {
                $X[$k][$j] /= $this->L[$k][$k];
            }
            for ($i = 0; $i < $k; ++$i) {
                for ($j = 0; $j < $nx; ++$j) {
                    $X[$i][$j] -= $X[$k][$j] * $this->L[$k][$i];
                }
            }
        }

        return new Matrix($X, $this->m, $nx);
    }
}