<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   Framework
 * @package    phpOMS\Message\Http
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
declare(strict_types = 1);

namespace phpOMS\Message\Http;

use phpOMS\Stdlib\Base\Enum;

/**
 * Request status enum.
 *
 * @category   Framework
 * @package    phpOMS\Message\Http
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
abstract class RequestStatus extends Enum
{
    /* public */ const R_100 = 'Continue';
    /* public */ const R_101 = 'Switching Protocols';
    /* public */ const R_102 = 'Processing';
    /* public */ const R_200 = 'OK';
    /* public */ const R_201 = 'Created';
    /* public */ const R_202 = 'Accepted';
    /* public */ const R_203 = 'Non-Authoritative Information';
    /* public */ const R_204 = 'No Content';
    /* public */ const R_205 = 'Reset Content';
    /* public */ const R_206 = 'Partial Content';
    /* public */ const R_207 = 'Multi-Status';
    /* public */ const R_300 = 'Multiple Choices';
    /* public */ const R_301 = 'Moved Permanently';
    /* public */ const R_302 = 'Found';
    /* public */ const R_303 = 'See Other';
    /* public */ const R_304 = 'Not Modified';
    /* public */ const R_305 = 'Use Proxy';
    /* public */ const R_306 = 'Switch Proxy';
    /* public */ const R_307 = 'Temporary Redirect';
    /* public */ const R_400 = 'Bad Request';
    /* public */ const R_401 = 'Unauthorized';
    /* public */ const R_402 = 'Payment Required';
    /* public */ const R_403 = 'Forbidden';
    /* public */ const R_404 = 'Not Found';
    /* public */ const R_405 = 'Method Not Allowed';
    /* public */ const R_406 = 'Not Acceptable';
    /* public */ const R_407 = 'Proxy Authentication Required';
    /* public */ const R_408 = 'Request Timeout';
    /* public */ const R_409 = 'Conflict';
    /* public */ const R_410 = 'Gone';
    /* public */ const R_411 = 'Length Required';
    /* public */ const R_412 = 'Precondition Failed';
    /* public */ const R_413 = 'Request Entity Too Large';
    /* public */ const R_414 = 'Request-URI Too Long';
    /* public */ const R_415 = 'Unsupported Media Type';
    /* public */ const R_416 = 'Requested Range Not Satisfiable';
    /* public */ const R_417 = 'Expectation Failed';
    /* public */ const R_418 = 'I\'m a teapot';
    /* public */ const R_422 = 'Unprocessable Entity';
    /* public */ const R_423 = 'Locked';
    /* public */ const R_424 = 'Failed Dependency';
    /* public */ const R_425 = 'Unordered Collection';
    /* public */ const R_426 = 'Upgrade Required';
    /* public */ const R_449 = 'Retry With';
    /* public */ const R_450 = 'Blocked by Windows Parental Controls';
    /* public */ const R_500 = 'Internal Server Error';
    /* public */ const R_501 = 'Not Implemented';
    /* public */ const R_502 = 'Bad Gateway';
    /* public */ const R_503 = 'Service Unavailable';
    /* public */ const R_504 = 'Gateway Timeout';
    /* public */ const R_505 = 'HTTP Version Not Supported';
    /* public */ const R_506 = 'Variant Also Negotiates';
    /* public */ const R_507 = 'Insufficient Storage';
    /* public */ const R_509 = 'Bandwidth Limit Exceeded';
    /* public */ const R_510 = 'Not Extended';
}
