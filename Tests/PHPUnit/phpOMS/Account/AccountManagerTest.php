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

namespace Tests\PHPUnit\phpOMS\Account;

use phpOMS\Account\Account;
use phpOMS\Account\AccountManager;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\DataStorage\Session\HttpSession;

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';

class AccountManagerTest extends \PHPUnit\Framework\TestCase
{

    public function testAttributes() {
        $manager = new AccountManager($GLOBALS['httpSession']);
        self::assertInstanceOf('\phpOMS\Account\AccountManager', $manager);

        /* Testing members */
        self::assertObjectHasAttribute('accounts', $manager);
    }

    public function testDefault() {
        $manager = new AccountManager($GLOBALS['httpSession']);

        self::assertEquals(0, $manager->count());
        self::assertInstanceOf('\phpOMS\Account\Account', $manager->get(0));
        self::assertInstanceOf('\phpOMS\Account\NullAccount', $manager->get(-1));
    }

    public function testSetGet()
    {
        $manager = new AccountManager($GLOBALS['httpSession']);
        $account = new Account(3);

        $account->generatePassword('abcd');

        $added = $manager->add($account);
        self::assertTrue($added);
        self::assertEquals($account, $manager->get($account->getId()));
        self::assertEquals(1, $manager->count());

        $added = $manager->add($account);
        self::assertFalse($added);

        self::assertTrue($manager->remove($account->getId()));
        self::assertFalse($manager->remove(-1));
        self::assertEquals(0, $manager->count());
        
    }
}
