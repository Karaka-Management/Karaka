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

use phpOMS\Account\Account;
use phpOMS\Account\Group;
use phpOMS\Account\AccountStatus;
use phpOMS\Account\AccountType;
use phpOMS\Account\PermissionAbstract;
use phpOMS\Account\PermissionType;
use phpOMS\Localization\L11nManager;
use phpOMS\Localization\Localization;
use phpOMS\Localization\NullLocalization;
use phpOMS\Log\FileLogger;

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';

class AccountTest extends \PHPUnit\Framework\TestCase
{
    protected $l11nManager = null;

    protected function setUp()
    {
        $this->l11nManager = new L11nManager();
    }

    public function testAttributes()
    {
        $account = new Account();
        self::assertInstanceOf('\phpOMS\Account\Account', $account);

        /* Testing members */
        self::assertObjectHasAttribute('id', $account);
        self::assertObjectHasAttribute('name1', $account);
        self::assertObjectHasAttribute('name2', $account);
        self::assertObjectHasAttribute('name3', $account);
        self::assertObjectHasAttribute('email', $account);
        self::assertObjectHasAttribute('origin', $account);
        self::assertObjectHasAttribute('login', $account);
        self::assertObjectHasAttribute('lastActive', $account);
        self::assertObjectHasAttribute('createdAt', $account);
        self::assertObjectHasAttribute('permissions', $account);
        self::assertObjectHasAttribute('groups', $account);
        self::assertObjectHasAttribute('type', $account);
        self::assertObjectHasAttribute('status', $account);
        self::assertObjectHasAttribute('l11n', $account);
    }

    public function testDefault()
    {
        $account = new Account();

        /* Testing default values */
        self::assertTrue(is_int($account->getId()));
        self::assertEquals(0, $account->getId());

        self::assertInstanceOf('\phpOMS\Localization\NullLocalization', $account->getL11n());

        self::assertEquals([], $account->getGroups());

        self::assertTrue(is_string($account->getName()));
        self::assertEquals('', $account->getName());

        self::assertTrue(is_string($account->getName1()));
        self::assertEquals('', $account->getName1());

        self::assertTrue(is_string($account->getName2()));
        self::assertEquals('', $account->getName2());

        self::assertTrue(is_string($account->getName3()));
        self::assertEquals('', $account->getName3());

        self::assertTrue(is_string($account->getEmail()));
        self::assertEquals('', $account->getEmail());

        self::assertTrue(is_int($account->getStatus()));
        self::assertEquals(AccountStatus::INACTIVE, $account->getStatus());

        self::assertTrue(is_int($account->getType()));
        self::assertEquals(AccountType::USER, $account->getType());

        self::assertEquals([], $account->getPermissions());

        self::assertInstanceOf('\DateTime', $account->getLastActive());
        self::assertInstanceOf('\DateTime', $account->getCreatedAt());

        $array = $account->toArray();
        self::assertTrue(is_array($array));
        self::assertGreaterThan(0, count($array));
        self::assertEquals(json_encode($array), $account->__toString());
        self::assertEquals($array, $account->jsonSerialize());
    }

    public function testSetGet()
    {
        $account = new Account();

        /* Just test if no error happens */
        $account->generatePassword('abcd');

        $account->addGroup(new Group());
        self::assertEquals(1, count($account->getGroups()));

        $account->setName('Login');
        self::assertEquals('Login', $account->getName());

        $account->setName1('Donald');
        self::assertEquals('Donald', $account->getName1());

        $account->setName2('Fauntleroy');
        self::assertEquals('Fauntleroy', $account->getName2());

        $account->setName3('Duck');
        self::assertEquals('Duck', $account->getName3());

        $account->setEmail('d.duck@duckburg.com');
        self::assertEquals('d.duck@duckburg.com', $account->getEmail());

        $account->setName('Login');
        self::assertEquals('Login', $account->getName());

        $account->setStatus(AccountStatus::ACTIVE);
        self::assertEquals(AccountStatus::ACTIVE, $account->getStatus());

        $account->setType(AccountType::GROUP);
        self::assertEquals(AccountType::GROUP, $account->getType());

        $account->addPermission(new class extends PermissionAbstract {});
        self::assertEquals(1, count($account->getPermissions()));

        $account->setPermissions([
            new class extends PermissionAbstract {},
            new class extends PermissionAbstract {},
        ]);
        self::assertEquals(2, count($account->getPermissions()));

        $account->addPermissions([
            new class extends PermissionAbstract {},
            new class extends PermissionAbstract {},
        ]);
        self::assertEquals(4, count($account->getPermissions()));

        self::assertFalse($account->hasPermission(PermissionType::READ, 1, 'a', 1, 1, 1, 1));
        self::assertTrue($account->hasPermission(PermissionType::NONE));

        $account->setL11n(new NullLocalization());
        self::assertInstanceOf('\phpOMS\Localization\NullLocalization', $account->getL11n());
        $account->setL11n(new Localization());
        self::assertInstanceOf('\phpOMS\Localization\Localization', $account->getL11n());
        self::assertNotInstanceOf('\phpOMS\Localization\NullLocalization', $account->getL11n());

        $datetime = new \DateTime('now');
        $account->updateLastActive();
        self::assertEquals($datetime->format('Y-m-d h:i:s'), $account->getLastActive()->format('Y-m-d h:i:s'));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testEmailException()
    {
        $account = new Account();
        $account->setEmail('d.duck!@#%@duckburg');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testStatusException()
    {
        $account = new Account();
        $account->setStatus(99);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testTypeException()
    {
        $account = new Account();
        $account->setType(99);
    }
}
