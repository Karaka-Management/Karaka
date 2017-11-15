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
class Vector extends Matrix
{
    /**
     * Constructor.
     *
     * @param int $m Columns
     *
     * @since  1.0.0
     */
    public function __construct(int $m = 1)
    {
        parent::__construct($m);
    }

    // todo: maybe overwrite setMatrix since only one column (is only a visual improvement)
}