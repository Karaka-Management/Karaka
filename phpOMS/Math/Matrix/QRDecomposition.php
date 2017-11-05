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

class QRDecomposition
{
    private $QR = [];

    private $m = 0;
    private $n = 0;

    private $Rdiag = [];

    public function __construct(Matrix $M)
    {
        // Initialize.
        $this->QR = $M->toArray();
        $this->m  = $M->getRowDimension();
        $this->n  = $M->getColumnDimension();
        
        // Main loop.
        for ($k = 0; $k < $this->n; ++$k) {
            // Compute 2-norm of k-th column without under/overflow.
            $nrm = 0.0;
            for ($i = $k; $i < $this->m; ++$i) {
                $nrm = hypo($nrm, $this->QR[$i][$k]);
            }
                
            if ($nrm != 0.0) {
                // Form k-th Householder vector.
                if ($this->QR[$k][$k] < 0) {
                    $nrm = -$nrm;
                }
                    
                for ($i = $k; $i < $this->m; ++$i) {
                    $this->QR[$i][$k] /= $nrm;
                }
                    
                $this->QR[$k][$k] += 1.0;
                // Apply transformation to remaining columns.
                for ($j = $k + 1; $j < $this->n; ++$j) {
                    $s = 0.0;
                    for ($i = $k; $i < $this->m; ++$i) {
                        $s += $this->QR[$i][$k] * $this->QR[$i][$j];
                    }
                        
                    $s = -$s / $this->QR[$k][$k];
                    for ($i = $k; $i < $this->m; ++$i) {
                        $this->QR[$i][$j] += $s * $this->QR[$i][$k];
                    }
                }
            }
                
            $this->Rdiag[$k] = -$nrm;
        }
    }

    public function isFullRank() : bool
    {
        for ($j = 0; $j < $this->n; ++$j) {
            if ($this->Rdiag[$j] == 0) {
                return false;
            }
        }
        
        return true;
    }

    public function getH()
    {
        $H = [[]];

        for ($i = 0; $i < $this->m; ++$i) {
            for ($j = 0; $j < $this->n; ++$j) {
                if ($i >= $j) {
                    $H[$i][$j] = $this->QR[$i][$j];
                } else {
                    $H[$i][$j] = 0.0;
                }
            }
        }
        
        $matrix = new Matrix();
        $matrix->setArray($H);

        return $this->matrix;
    }

    public function getR()
    {
        $R = [[]];

        for ($i = 0; $i < $this->n; ++$i) {
            for ($j = 0; $j < $this->n; ++$j) {
                if ($i < $j) {
                    $R[$i][$j] = $this->QR[$i][$j];
                } elseif ($i == $j) {
                    $R[$i][$j] = $this->Rdiag[$i];
                } else {
                    $R[$i][$j] = 0.0;
                }
            }
        }
        
        $matrix = new Matrix();
        $matrix->setArray($R);

        return $this->matrix;
    }

    public function getQ()
    {
        $Q = [[]];

        for ($k = $this->n - 1; $k >= 0; --$k) {
            for ($i = 0; $i < $this->m; ++$i) {
                $Q[$i][$k] = 0.0;
            }
            
            $Q[$k][$k] = 1.0;
            for ($j = $k; $j < $this->n; ++$j) {
                if ($this->QR[$k][$k] != 0) {
                    $s = 0.0;
                    for ($i = $k; $i < $this->m; ++$i) {
                        $s += $this->QR[$i][$k] * $Q[$i][$j];
                    }
                    $s = -$s / $this->QR[$k][$k];
                    for ($i = $k; $i < $this->m; ++$i) {
                        $Q[$i][$j] += $s * $this->QR[$i][$k];
                    }
                }
            }
        }
        
        $matrix = new Matrix();
        $matrix->setArray($Q);

        return $this->matrix;
    }

    public function solve(Matrix $B) 
    {
        if ($B->getRowDimension() !== $this->m) {
        }

        if (!$this->isFullRank()) {
        }

        $nx = $B->getColumnDimension();
        $X  = $B->getArrayCopy();
        // Compute Y = transpose(Q)*B
        for ($k = 0; $k < $this->n; ++$k) {
            for ($j = 0; $j < $nx; ++$j) {
                $s = 0.0;
                for ($i = $k; $i < $this->m; ++$i) {
                    $s += $this->QR[$i][$k] * $X[$i][$j];
                }
                $s = -$s / $this->QR[$k][$k];
                for ($i = $k; $i < $this->m; ++$i) {
                    $X[$i][$j] += $s * $this->QR[$i][$k];
                }
            }
        }
        // Solve R*X = Y;
        for ($k = $this->n - 1; $k >= 0; --$k) {
            for ($j = 0; $j < $nx; ++$j) {
                $X[$k][$j] /= $this->Rdiag[$k];
            }
            for ($i = 0; $i < $k; ++$i) {
                for ($j = 0; $j < $nx; ++$j) {
                    $X[$i][$j] -= $X[$k][$j] * $this->QR[$i][$k];
                }
            }
        }

        $matrix = new Matrix();
        $matrix->setArray($X);

        return $matrix->getMatrix(0, $this->n - 1, 0, $nx);
    }
}