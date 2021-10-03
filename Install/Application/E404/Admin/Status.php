<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   Web\E404\Admin
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Web\E404\Admin;

use phpOMS\Application\StatusAbstract;

/**
 * Status class.
 *
 * @package Web\E404\Admin
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
final class Status extends StatusAbstract
{
    /**
     * Path of the file
     *
     * @var string
     * @since 1.0.0
     */
    public const PATH = __DIR__;
}
