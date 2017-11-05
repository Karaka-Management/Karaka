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

namespace Tests\PHPUnit\phpOMS\DataStorage\Session;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\DataStorage\Session\HttpSession;

class HttpSessionTest extends \PHPUnit\Framework\TestCase
{
    public function testDefault()
    {
        $session = new HttpSession();
        self::assertEquals(null, $session->get('key'));
        self::assertGreaterThan(0, strlen($session->getSID()));
        self::assertFalse(HttpSession::isLocked());
    }

    public function testGetSet()
    {
        $session = new HttpSession(1, false, 1);
        self::assertTrue($session->set('test', 'value'));
        self::assertEquals('value', $session->get('test'));

        self::assertFalse($session->set('test', 'value2', false));
        self::assertEquals('value', $session->get('test'));

        self::assertTrue($session->set('test', 'value3'));
        self::assertEquals('value3', $session->get('test'));

        self::assertTrue($session->remove('test'));
        self::assertFalse($session->remove('test'));

        $session->setSID('abc');
        self::assertEquals('abc', $session->getSID());
    }
}
