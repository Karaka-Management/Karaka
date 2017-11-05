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
namespace Modules\Media\Models;

use phpOMS\Stdlib\Base\Enum;

/**
 * Upload status.
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
abstract class UploadStatus extends Enum
{
    /* public */ const OK               = 0;
    /* public */ const WRONG_PARAMETERS = -1;
    /* public */ const NOTHING_UPLOADED = -2;
    /* public */ const UPLOAD_SIZE      = -3;
    /* public */ const UNKNOWN_ERROR    = -4;
    /* public */ const CONFIG_SIZE      = -5;
    /* public */ const WRONG_EXTENSION  = -6;
    /* public */ const NOT_UPLOADED     = -7;
    /* public */ const NOT_MOVABLE      = -8;
    /* public */ const FAILED_HASHING   = -9;
}
