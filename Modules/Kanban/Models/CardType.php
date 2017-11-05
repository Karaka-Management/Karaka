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

namespace Modules\Kanban\Models;

use phpOMS\Stdlib\Base\Enum;

/**
 * Area type enum.
 *
 * @category   Framework
 * @package    phpOMS\Utils\Converter
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
abstract class CardType extends Enum
{
    /* public */ const TEXT = 1; /* Markdown -> Image, links, charts etc */
    /* public */ const CALENDAR = 2;
    /* public */ const CALENDAR_EVENT = 4;
    /* public */ const TASK = 8;
    /* public */ const TASK_CHECKLIST = 16;
    /* public */ const MEDIA = 32;
    /* public */ const SURVEY = 64;
}