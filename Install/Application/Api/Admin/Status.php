<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   Web\Api\Admin
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Web\Api\Admin;

use phpOMS\Application\StatusAbstract;

/**
 * Status class.
 *
 * @package Web\Api\Admin
 * @license OMS License 1.0
 * @link    https://jingga.app
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
