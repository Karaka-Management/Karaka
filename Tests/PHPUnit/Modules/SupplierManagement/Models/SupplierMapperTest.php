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

namespace Tests\PHPUnit\Modules\SupplierManagement\Models;

use Modules\SupplierManagement\Models\Supplier;
use Modules\SupplierManagement\Models\SupplierMapper;
use phpOMS\Account\AccountStatus;
use phpOMS\Account\AccountType;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Utils\RnG\Name;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class SupplierMapperTest extends \PHPUnit\Framework\TestCase
{

    public function testCRUD()
    {
        $supplier = new Supplier();

        $supplier->getProfile()->getAccount()->setName1('Name1');
        $supplier->getProfile()->getAccount()->setName2('Name2');
        $supplier->getProfile()->getAccount()->setName3('Name3');
        $supplier->getProfile()->getAccount()->setEmail('d.test@duckburg.com');
        $supplier->getProfile()->getAccount()->setStatus(AccountStatus::ACTIVE);
        $supplier->getProfile()->getAccount()->setType(AccountType::USER);

        $supplier->setNumber(1);
        $supplier->setReverseNumber('asdf');
        $supplier->setStatus(2);
        $supplier->setType(3);
        $supplier->setTaxId('a123546');
        $supplier->setInfo('Some info.');

        $id = SupplierMapper::create($supplier);
        self::assertGreaterThan(0, $supplier->getId());
        self::assertEquals($id, $supplier->getId());

        $supplierR = SupplierMapper::get($supplier->getId());
        self::assertEquals($supplier->getCreatedAt()->format('Y-m-d'), $supplierR->getCreatedAt()->format('Y-m-d'));
        self::assertEquals($supplier->getProfile()->getAccount()->getName1(), $supplierR->getProfile()->getAccount()->getName1());
        self::assertEquals($supplier->getProfile()->getAccount()->getName2(), $supplierR->getProfile()->getAccount()->getName2());
        self::assertEquals($supplier->getProfile()->getAccount()->getName3(), $supplierR->getProfile()->getAccount()->getName3());
        self::assertEquals($supplier->getProfile()->getAccount()->getStatus(), $supplierR->getProfile()->getAccount()->getStatus());
        self::assertEquals($supplier->getProfile()->getAccount()->getType(), $supplierR->getProfile()->getAccount()->getType());
        self::assertEquals($supplier->getProfile()->getAccount()->getEmail(), $supplierR->getProfile()->getAccount()->getEmail());

        self::assertEquals(1, $supplier->getNumber());
        self::assertEquals('asdf', $supplier->getReverseNumber());
        self::assertEquals(2, $supplier->getStatus());
        self::assertEquals(3, $supplier->getType());
        self::assertEquals('a123546', $supplier->getTaxId());
        self::assertEquals('Some info.', $supplier->getInfo());
    }

    /**
     * @group volume
     */
    public function testVolume()
    {
        for ($i = 1; $i < 100; $i++) {
            $supplier = new Supplier();

            $supplier->getProfile()->getAccount()->setName1(Name::generateName(['female', 'male']));
            $supplier->getProfile()->getAccount()->setName2(Name::generateName(['family']));
            $supplier->getProfile()->getAccount()->setStatus(AccountStatus::ACTIVE);
            $supplier->getProfile()->getAccount()->setType(AccountType::USER);

            $supplier->setNumber($i + 1);
            $supplier->setStatus(2);
            $supplier->setType(3);

            $id = SupplierMapper::create($supplier);
        }
    }
}
