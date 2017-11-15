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

namespace phpOMS\Math\Matrix;

class CholeskyDecomposition
{
    private $L = [];

    private $m = 0;

    /**
     * Is symmetric positive definite
     */
    private $isSpd = true;

    // see http://www.aip.de/groups/soe/local/numres/bookfpdf/f2-9.pdf
    public function __construct(Matrix $M)
    {
        $this->L = $M->toArray();
        $this->m = $M->getM();

        for ($i = 0; $i < $this->m; ++$i) {
            for ($j = $i; $j < $this->m; ++$j) {
                for ($sum = $this->L[$i][$j], $k = $i - 1; $k >= 0; --$k) {
                    $sum -= $this->L[$i][$k] * $this->L[$j][$k];
                }

                if ($i === $j) {
                    if ($sum >= 0) {
                        $this->L[$i][$i] = sqrt($sum);
                    } else {
                        $this->isSpd = false;
                    }
                } else {
                    if ($this->L[$i][$i] !== 0) {
                        $this->L[$j][$i] = $sum / $this->L[$i][$i];
                    }
                }
            }

            for ($k = $i + 1; $k < $this->m; ++$k) {
                $this->L[$i][$k] = 0.0;
            }
        }
    }

    public function isSpd() : bool
    {
        return $this->isSpd;
    }

    public function getL() : Matrix
    {
        $matrix = new Matrix();
        $matrix->setMatrix($this->L);

        return $matrix;
    }

    public function solve(Matrix $B) : Matrix
    {
        if ($B->getM() !== $this->m) {
            throw new \Exception();
        }

        if (!$this->isSpd) {
            throw new \Exception();
        }

        $X = $B->toArray();
        $n = $B->getN();

        // Solve L*Y = B;
        for ($k = 0; $k < $this->m; $k++) {
	        for ($j = 0; $j < $n; $j++) {
	            for ($i = 0; $i < $k ; $i++) {
	                $X[$k][$j] -= $X[$i][$j] * $this->L[$k][$i];
                }
               
	            $X[$k][$j] /= $this->L[$k][$k];
	        }
	    }
    
        // Solve L'*X = Y;
	    for ($k = $this->m - 1; $k >= 0; $k--) {
	        for ($j = 0; $j < $n; $j++) {
	            for ($i = $k + 1; $i < $this->m ; $i++) {
	                $X[$k][$j] -= $X[$i][$j] * $this->L[$i][$k];
                }
               
	            $X[$k][$j] /= $this->L[$k][$k];
	        }
	    }

        $solution = new Matrix();
        $solution->setMatrix($X);

        return $solution;
    }
}