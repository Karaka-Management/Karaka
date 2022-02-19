<?php
/**
 * Karaka
 *
 * PHP Version 8.0
 *
 * @package   Model
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
 */
declare(strict_types=1);

namespace Model;

/**
 * Null model.
 *
 * @package Model
 * @license OMS License 1.0
 * @link    https://karaka.app
 * @since   1.0.0
 */
final class NullSetting extends Setting
{
    /**
     * Constructor
     *
     * @param int $id Model id
     *
     * @since 1.0.0
     */
    public function __construct(int $id = 0)
    {
        $this->id = $id;
    }
}
