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

/**
 * Matrix class
 *
 * @category   Framework
 * @package    phpOMS\Math\Matrix
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class IdentityMatrix extends Matrix
{
    /**
     * Constructor.
     *
     * @param int $n Matrix dimension
     *
     * @since  1.0.0
     */
    public function __constrcut(int $n)
    {
        $this->n = $n;
        $this->m = $n;

        for ($i = 0; $i < $n; $i++) {
            $this->matrix[$i]     = array_fill(0, $n, 0);
            $this->matrix[$i][$i] = 1;
        }
    }
}