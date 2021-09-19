<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   Model
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Model;

use phpOMS\Stdlib\Base\Enum;

/**
 * App status enum.
 *
 * @package Model
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
abstract class AppStatus extends Enum
{
    public const NORMAL = 1;

    public const READ_ONLY = 2;

    public const DISABLED = 3;
}
