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
 * News type enum.
 *
 * @category   Module
 * @package    Modules\News
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
abstract class NewsType extends Enum
{
    /* public */ const ARTICLE = 0;
    /* public */ const LINK = 1;
    /* public */ const HEADLINE = 2;
}
