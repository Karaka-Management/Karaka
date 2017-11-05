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
 * @link       http://website.orange-management.de
 */

namespace Tests\PHPUnit\phpOMS\Message;

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';

use phpOMS\Message\RequestSource;

class RequestSourceTest extends \PHPUnit\Framework\TestCase
{
    public function testEnums()
    {
        self::assertEquals(4, count(RequestSource::getConstants()));
        self::assertEquals(0, RequestSource::WEB);
        self::assertEquals(1, RequestSource::CONSOLE);
        self::assertEquals(2, RequestSource::SOCKET);
        self::assertEquals(3, RequestSource::UNDEFINED);
    }
}
