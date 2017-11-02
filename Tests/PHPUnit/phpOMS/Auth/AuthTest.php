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

namespace Tests\PHPUnit\phpOMS\Account;

use phpOMS\Auth\Auth;
use phpOMS\Auth\LoginReturnType;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\DataStorage\Session\ConsoleSession;
use phpOMS\DataStorage\Session\SocketSession;

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';

class AuthTest extends \PHPUnit\Framework\TestCase
{
    public function testAttributes()
    {
        $auth = new Auth($GLOBALS['httpSession']);
        self::assertInstanceOf('\phpOMS\Auth\Auth', $auth);

        /* Testing members */
        self::assertObjectHasAttribute('session', $auth);
    }

    public function testWithHttpSession()
    {
        $auth = new Auth($GLOBALS['httpSession']);

        self::assertEquals(0, $auth->authenticate());

        $auth->logout();
        self::assertEquals(0, $auth->authenticate());
    }

    public function testWithSocketSession()
    {
        $session = new SocketSession();
        $auth = new Auth($session);

        self::assertEquals(0, $auth->authenticate());
    }

    public function testWithConsoleSession()
    {
        $session = new ConsoleSession();
        $auth = new Auth($session);

        self::assertEquals(0, $auth->authenticate());
    }
}
