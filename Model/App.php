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

use phpOMS\Application\ApplicationStatus;

/**
 * App model.
 *
 * @package Model
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
class App
{
    /**
     * Id
     *
     * @var int
     * @since 1.0.0
     */
    protected int $id = 0;

    /**
     * Name
     *
     * @var string
     * @since 1.0.0
     */
    public string $name = '';

    /**
     * Theme
     *
     * @var string
     * @since 1.0.0
     */
    public string $theme = '';

    /**
     * Status
     *
     * @var int
     * @since 1.0.0
     */
    public int $status = ApplicationStatus::NORMAL;
}