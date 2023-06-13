<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   Web\E404
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Web\E404;

use phpOMS\Model\Html\Head;
use phpOMS\Views\View;

/**
 * List view.
 *
 * @package Web\E404
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
class ErrorView extends View
{
    /**
     * Head
     *
     * @var Head
     * @since 1.0.0
     */
    public ?Head $head = null;
}
