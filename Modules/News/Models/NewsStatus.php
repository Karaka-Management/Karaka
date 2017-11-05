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
namespace Modules\News\Models;

use phpOMS\Stdlib\Base\Enum;

/**
 * News type status.
 *
 * @category   Module
 * @package    Modules\News
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
abstract class NewsStatus extends Enum
{
    /* public */ const VISIBLE = 0;

    /* public */ const DRAFT = 1;
}
