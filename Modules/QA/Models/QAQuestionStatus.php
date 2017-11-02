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
 * @link       http://orange-management.com
 */
declare(strict_types = 1);
namespace Modules\QA\Models;

use phpOMS\Stdlib\Base\Enum;

/**
 * Task status enum.
 *
 * @category   QA
 * @package    Modules
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
abstract class QAQuestionStatus extends Enum
{
    /* public */ const ACTIVE = 1;

    /* public */ const INACTIVE = 2;
    
    /* public */ const BLOCKED = 4;
}
