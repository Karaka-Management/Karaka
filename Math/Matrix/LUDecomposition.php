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

class LUDecomposition
{
    private $LU = [];

    private $m = 0;
    private $n = 0;

    private $pivSign = 1;

    private $piv = [];

    public function __construct(Matrix $M)
    {
        $this->LU = $M->toArray();
        $this->m  = $M->getM();
        $this->n  = $M->getN();

        for ($i = 0; $i < $this->m; ++$i) {
            $this->piv[$i] = $i;
        }

        $this->pivSign = 1;
        $LUrowi = $LUcolj = [];

        for ($j = 0; $j < $this->n; ++$j) {
            // Make a copy of the j-th column to localize references.
            for ($i = 0; $i < $this->m; ++$i) {
                $LUcolj[$i] = &$this->LU[$i][$j];
            }
            // Apply previous transformations.
            for ($i = 0; $i < $this->m; ++$i) {
                $LUrowi = $this->LU[$i];
                // Most of the time is spent in the following dot product.
                $kmax = min($i, $j);
                $s = 0.0;
                for ($k = 0; $k < $kmax; ++$k) {
                    $s += $LUrowi[$k] * $LUcolj[$k];
                }
                $LUrowi[$j] = $LUcolj[$i] -= $s;
            }
            // Find pivot and exchange if necessary.
            $p = $j;
            for ($i = $j + 1; $i < $this->m; ++$i) {
                if (abs($LUcolj[$i]) > abs($LUcolj[$p])) {
                    $p = $i;
                }
            }
            if ($p != $j) {
                for ($k = 0; $k < $this->n; ++$k) {
                    $t = $this->LU[$p][$k];
                    $this->LU[$p][$k] = $this->LU[$j][$k];
                    $this->LU[$j][$k] = $t;
                }
                $k = $this->piv[$p];
                $this->piv[$p] = $this->piv[$j];
                $this->piv[$j] = $k;
                $this->pivSign = $this->pivSign * -1;
            }
            // Compute multipliers.
            if (($j < $this->m) && ($this->LU[$j][$j] != 0.0)) {
                for ($i = $j + 1; $i < $this->m; ++$i) {
                    $this->LU[$i][$j] /= $this->LU[$j][$j];
                }
            }
        }
    }

    public function getL()
    {
        $L = [[]];

        for ($i = 0; $i < $this->m; ++$i) {
            for ($j = 0; $j < $this->n; ++$j) {
                if ($i > $j) {
                    $L[$i][$j] = $this->LU[$i][$j];
                } elseif ($i == $j) {
                    $L[$i][$j] = 1.0;
                } else {
                    $L[$i][$j] = 0.0;
                }
            }
        }
        
        $matrix = new Matrix();
        $matrix->setMatrix($L);

        return $matrix;
    }

    public function getU()
    {
        $U = [[]];

        for ($i = 0; $i < $this->n; ++$i) {
            for ($j = 0; $j < $this->n; ++$j) {
                if ($i <= $j) {
                    $U[$i][$j] = $this->LU[$i][$j];
                } else {
                    $U[$i][$j] = 0.0;
                }
            }
        }
        
        $matrix = new Matrix();
        $matrix->setMatrix($U);

        return $matrix;
    }

    public function getPivot()
    {
        return $this->piv;
    }

    public function isNonsingular() : bool
    {
        for ($j = 0; $j < $this->n; ++$j) {
            if ($this->LU[$j][$j] == 0) {
                return false;
            }
        }
        
        return true;
    }

    public function det() 
    {
        $d = $this->pivSign;
        for ($j = 0; $j < $this->n; ++$j) {
            $d *= $this->LU[$j][$j];
        }

        return $d;
    }

    public function solve(Matrix $B)
    {
        if ($B->getM() !== $this->m) {
        }

        if (!$this->isNonsingular()) {
        }

        $nx = $B->getM();
        $X  = $B->getMatrix($this->piv, 0, $nx - 1);

        // Solve L*Y = B(piv,:)
        for ($k = 0; $k < $this->n; ++$k) {
            for ($i = $k + 1; $i < $this->n; ++$i) {
                for ($j = 0; $j < $nx; ++$j) {
                    $X->A[$i][$j] -= $X->A[$k][$j] * $this->LU[$i][$k];
                }
            }
        }

        // Solve U*X = Y;
        for ($k = $this->n - 1; $k >= 0; --$k) {
            for ($j = 0; $j < $nx; ++$j) {
                $X->A[$k][$j] /= $this->LU[$k][$k];
            }
            for ($i = 0; $i < $k; ++$i) {
                for ($j = 0; $j < $nx; ++$j) {
                    $X->A[$i][$j] -= $X->A[$k][$j] * $this->LU[$i][$k];
                }
            }
        }

        return $X;
    }
}