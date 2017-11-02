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
namespace phpOMS\Message\Http;

use phpOMS\Stdlib\Base\Enum;

/**
 * Request status enum.
 *
 * @category   Request
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
abstract class RequestStatusCode extends Enum
{
    /* public */ const R_100 = 100;
    /* public */ const R_101 = 101;
    /* public */ const R_102 = 102;
    /* public */ const R_200 = 200;
    /* public */ const R_201 = 201;
    /* public */ const R_202 = 202;
    /* public */ const R_203 = 203;
    /* public */ const R_204 = 204;
    /* public */ const R_205 = 205;
    /* public */ const R_206 = 206;
    /* public */ const R_207 = 207;
    /* public */ const R_300 = 300;
    /* public */ const R_301 = 301;
    /* public */ const R_302 = 302;
    /* public */ const R_303 = 303;
    /* public */ const R_304 = 304;
    /* public */ const R_305 = 305;
    /* public */ const R_306 = 306;
    /* public */ const R_307 = 307;
    /* public */ const R_400 = 400;
    /* public */ const R_401 = 401;
    /* public */ const R_402 = 402;
    /* public */ const R_403 = 403;
    /* public */ const R_404 = 404;
    /* public */ const R_405 = 405;
    /* public */ const R_406 = 406;
    /* public */ const R_407 = 407;
    /* public */ const R_408 = 408;
    /* public */ const R_409 = 409;
    /* public */ const R_410 = 410;
    /* public */ const R_411 = 411;
    /* public */ const R_412 = 412;
    /* public */ const R_413 = 413;
    /* public */ const R_414 = 414;
    /* public */ const R_415 = 415;
    /* public */ const R_416 = 416;
    /* public */ const R_417 = 417;
    /* public */ const R_418 = 418;
    /* public */ const R_422 = 422;
    /* public */ const R_423 = 423;
    /* public */ const R_424 = 424;
    /* public */ const R_425 = 425;
    /* public */ const R_426 = 426;
    /* public */ const R_449 = 449;
    /* public */ const R_450 = 450;
    /* public */ const R_500 = 500;
    /* public */ const R_501 = 501;
    /* public */ const R_502 = 502;
    /* public */ const R_503 = 503;
    /* public */ const R_504 = 504;
    /* public */ const R_505 = 505;
    /* public */ const R_506 = 506;
    /* public */ const R_507 = 507;
    /* public */ const R_509 = 509;
    /* public */ const R_510 = 510;
}
