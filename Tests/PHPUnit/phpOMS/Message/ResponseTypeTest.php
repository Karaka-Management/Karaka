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

namespace Tests\PHPUnit\phpOMS\Message;

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';

use phpOMS\Message\ResponseType;

class ResponseTypeTest extends \PHPUnit\Framework\TestCase
{
    public function testEnums()
    {
        self::assertEquals(3, count(ResponseType::getConstants()));
        self::assertEquals(0, ResponseType::HTTP);
        self::assertEquals(1, ResponseType::SOCKET);
        self::assertEquals(2, ResponseType::CONSOLE);
    }
}
