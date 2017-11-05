<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   Framework
 * @package    phpOMS\Localization
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
declare(strict_types = 1);

namespace phpOMS\Localization;

use phpOMS\Stdlib\Base\EnumArray;

/**
 * Datetime ISO format.
 *
 * Careful only (1) is considered as the ISO8601 standard. This file is only supposed to
 * contain all plausible datetime strings.
 *
 * @category   Framework
 * @package    phpOMS\Localization
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class ISO8601EnumArray extends EnumArray
{
    protected static $constants = [
        1 => 'YYYY-MM-DD hh:mm:ss', // ietf: rfc3339
        2 => 'YYYY.MM.DD hh:mm:ss',
        3 => 'DD-MM-YYYY hh:mm:ss',
        4 => 'DD.MM.YYYY hh:mm:ss',
    ];
}
