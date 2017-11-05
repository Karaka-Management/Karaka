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

namespace Tests\PHPUnit\Modules\Admin\Models;

use Modules\Admin\Models\Account;
use Modules\Admin\Models\AccountMapper;
use phpOMS\Account\AccountStatus;
use phpOMS\Account\AccountType;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Utils\RnG\Name;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class AccountMapperTest extends \PHPUnit\Framework\TestCase
{

    public function testCRUD()
    {
        $account = new Account();

        $account->setName1('Donald');
        $account->setName2('Fauntleroy');
        $account->setName3('Duck');
        $account->setEmail('d.duck@duckburg.com');
        $account->setStatus(AccountStatus::ACTIVE);
        $account->setType(AccountType::USER);

        $id = AccountMapper::create($account);
        self::assertGreaterThan(0, $account->getId());
        self::assertEquals($id, $account->getId());

        $accountR = AccountMapper::get($account->getId());
        self::assertEquals($account->getCreatedAt()->format('Y-m-d'), $accountR->getCreatedAt()->format('Y-m-d'));
        self::assertEquals($account->getName1(), $accountR->getName1());
        self::assertEquals($account->getName2(), $accountR->getName2());
        self::assertEquals($account->getName3(), $accountR->getName3());
        self::assertEquals($account->getStatus(), $accountR->getStatus());
        self::assertEquals($account->getType(), $accountR->getType());
        self::assertEquals($account->getEmail(), $accountR->getEmail());
    }
}
