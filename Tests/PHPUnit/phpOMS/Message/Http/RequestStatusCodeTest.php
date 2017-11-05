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

namespace Tests\PHPUnit\phpOMS\Message\Http;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Message\Http\RequestStatusCode;

class RequestStatusCodeTest extends \PHPUnit\Framework\TestCase
{
    public function testEnums()
    {
        self::assertEquals(55, count(RequestStatusCode::getConstants()));
        self::assertEquals(RequestStatusCode::getConstants(), array_unique(RequestStatusCode::getConstants()));
        
        self::assertEquals(100, RequestStatusCode::R_100);
        self::assertEquals(101, RequestStatusCode::R_101);
        self::assertEquals(102, RequestStatusCode::R_102);
        self::assertEquals(200, RequestStatusCode::R_200);
        self::assertEquals(201, RequestStatusCode::R_201);
        self::assertEquals(202, RequestStatusCode::R_202);
        self::assertEquals(203, RequestStatusCode::R_203);
        self::assertEquals(204, RequestStatusCode::R_204);
        self::assertEquals(205, RequestStatusCode::R_205);
        self::assertEquals(206, RequestStatusCode::R_206);
        self::assertEquals(207, RequestStatusCode::R_207);
        self::assertEquals(300, RequestStatusCode::R_300);
        self::assertEquals(301, RequestStatusCode::R_301);
        self::assertEquals(302, RequestStatusCode::R_302);
        self::assertEquals(303, RequestStatusCode::R_303);
        self::assertEquals(304, RequestStatusCode::R_304);
        self::assertEquals(305, RequestStatusCode::R_305);
        self::assertEquals(306, RequestStatusCode::R_306);
        self::assertEquals(307, RequestStatusCode::R_307);
        self::assertEquals(400, RequestStatusCode::R_400);
        self::assertEquals(401, RequestStatusCode::R_401);
        self::assertEquals(402, RequestStatusCode::R_402);
        self::assertEquals(403, RequestStatusCode::R_403);
        self::assertEquals(404, RequestStatusCode::R_404);
        self::assertEquals(405, RequestStatusCode::R_405);
        self::assertEquals(406, RequestStatusCode::R_406);
        self::assertEquals(407, RequestStatusCode::R_407);
        self::assertEquals(408, RequestStatusCode::R_408);
        self::assertEquals(409, RequestStatusCode::R_409);
        self::assertEquals(410, RequestStatusCode::R_410);
        self::assertEquals(411, RequestStatusCode::R_411);
        self::assertEquals(412, RequestStatusCode::R_412);
        self::assertEquals(413, RequestStatusCode::R_413);
        self::assertEquals(414, RequestStatusCode::R_414);
        self::assertEquals(415, RequestStatusCode::R_415);
        self::assertEquals(416, RequestStatusCode::R_416);
        self::assertEquals(417, RequestStatusCode::R_417);
        self::assertEquals(418, RequestStatusCode::R_418);
        self::assertEquals(422, RequestStatusCode::R_422);
        self::assertEquals(423, RequestStatusCode::R_423);
        self::assertEquals(424, RequestStatusCode::R_424);
        self::assertEquals(425, RequestStatusCode::R_425);
        self::assertEquals(426, RequestStatusCode::R_426);
        self::assertEquals(449, RequestStatusCode::R_449);
        self::assertEquals(450, RequestStatusCode::R_450);
        self::assertEquals(500, RequestStatusCode::R_500);
        self::assertEquals(501, RequestStatusCode::R_501);
        self::assertEquals(502, RequestStatusCode::R_502);
        self::assertEquals(503, RequestStatusCode::R_503);
        self::assertEquals(504, RequestStatusCode::R_504);
        self::assertEquals(505, RequestStatusCode::R_505);
        self::assertEquals(506, RequestStatusCode::R_506);
        self::assertEquals(507, RequestStatusCode::R_507);
        self::assertEquals(509, RequestStatusCode::R_509);
        self::assertEquals(510, RequestStatusCode::R_510);
    }
}
