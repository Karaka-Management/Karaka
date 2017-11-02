<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   TBD
 * @package    TBD
 * @author     OMS Development Team <dev@oms.com>
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://orange-management.com
 */

namespace Tests\PHPUnit\phpOMS\Message\Http;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Message\Http\RequestStatus;

class RequestStatusTest extends \PHPUnit\Framework\TestCase
{
    public function testEnums()
    {
        self::assertEquals(55, count(RequestStatus::getConstants()));
        self::assertEquals(RequestStatus::getConstants(), array_unique(RequestStatus::getConstants()));
        
        self::assertEquals('Continue', RequestStatus::R_100);
        self::assertEquals('Switching Protocols', RequestStatus::R_101);
        self::assertEquals('Processing', RequestStatus::R_102);
        self::assertEquals('OK', RequestStatus::R_200);
        self::assertEquals('Created', RequestStatus::R_201);
        self::assertEquals('Accepted', RequestStatus::R_202);
        self::assertEquals('Non-Authoritative Information', RequestStatus::R_203);
        self::assertEquals('No Content', RequestStatus::R_204);
        self::assertEquals('Reset Content', RequestStatus::R_205);
        self::assertEquals('Partial Content', RequestStatus::R_206);
        self::assertEquals('Multi-Status', RequestStatus::R_207);
        self::assertEquals('Multiple Choices', RequestStatus::R_300);
        self::assertEquals('Moved Permanently', RequestStatus::R_301);
        self::assertEquals('Found', RequestStatus::R_302);
        self::assertEquals('See Other', RequestStatus::R_303);
        self::assertEquals('Not Modified', RequestStatus::R_304);
        self::assertEquals('Use Proxy', RequestStatus::R_305);
        self::assertEquals('Switch Proxy', RequestStatus::R_306);
        self::assertEquals('Temporary Redirect', RequestStatus::R_307);
        self::assertEquals('Bad Request', RequestStatus::R_400);
        self::assertEquals('Unauthorized', RequestStatus::R_401);
        self::assertEquals('Payment Required', RequestStatus::R_402);
        self::assertEquals('Forbidden', RequestStatus::R_403);
        self::assertEquals('Not Found', RequestStatus::R_404);
        self::assertEquals('Method Not Allowed', RequestStatus::R_405);
        self::assertEquals('Not Acceptable', RequestStatus::R_406);
        self::assertEquals('Proxy Authentication Required', RequestStatus::R_407);
        self::assertEquals('Request Timeout', RequestStatus::R_408);
        self::assertEquals('Conflict', RequestStatus::R_409);
        self::assertEquals('Gone', RequestStatus::R_410);
        self::assertEquals('Length Required', RequestStatus::R_411);
        self::assertEquals('Precondition Failed', RequestStatus::R_412);
        self::assertEquals('Request Entity Too Large', RequestStatus::R_413);
        self::assertEquals('Request-URI Too Long', RequestStatus::R_414);
        self::assertEquals('Unsupported Media Type', RequestStatus::R_415);
        self::assertEquals('Requested Range Not Satisfiable', RequestStatus::R_416);
        self::assertEquals('Expectation Failed', RequestStatus::R_417);
        self::assertEquals('I\'m a teapot', RequestStatus::R_418);
        self::assertEquals('Unprocessable Entity', RequestStatus::R_422);
        self::assertEquals('Locked', RequestStatus::R_423);
        self::assertEquals('Failed Dependency', RequestStatus::R_424);
        self::assertEquals('Unordered Collection', RequestStatus::R_425);
        self::assertEquals('Upgrade Required', RequestStatus::R_426);
        self::assertEquals('Retry With', RequestStatus::R_449);
        self::assertEquals('Blocked by Windows Parental Controls', RequestStatus::R_450);
        self::assertEquals('Internal Server Error', RequestStatus::R_500);
        self::assertEquals('Not Implemented', RequestStatus::R_501);
        self::assertEquals('Bad Gateway', RequestStatus::R_502);
        self::assertEquals('Service Unavailable', RequestStatus::R_503);
        self::assertEquals('Gateway Timeout', RequestStatus::R_504);
        self::assertEquals('HTTP Version Not Supported', RequestStatus::R_505);
        self::assertEquals('Variant Also Negotiates', RequestStatus::R_506);
        self::assertEquals('Insufficient Storage', RequestStatus::R_507);
        self::assertEquals('Bandwidth Limit Exceeded', RequestStatus::R_509);
        self::assertEquals('Not Extended', RequestStatus::R_510);
    }
}
