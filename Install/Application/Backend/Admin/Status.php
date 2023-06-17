<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Web\Backend\Admin
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Web\Backend\Admin;

use phpOMS\Application\StatusAbstract;

/**
 * Status class.
 *
 * @package Web\Backend\Admin
 * @license OMS License 2.0
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
