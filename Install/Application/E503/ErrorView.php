<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Web\E503
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Web\E503;

use phpOMS\Model\Html\Head;
use phpOMS\Views\View;

/**
 * List view.
 *
 * @package Web\E503
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
