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

namespace Tests\PHPUnit\Modules\ClientManagement\Models;

use Modules\ClientManagement\Models\Client;
use Modules\ClientManagement\Models\ClientMapper;
use phpOMS\Account\AccountStatus;
use phpOMS\Account\AccountType;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Utils\RnG\Name;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class ClientMapperTest extends \PHPUnit\Framework\TestCase
{

    public function testCRUD()
    {
        $client = new Client();

        $client->getProfile()->getAccount()->setName1('Name1');
        $client->getProfile()->getAccount()->setName2('Name2');
        $client->getProfile()->getAccount()->setName3('Name3');
        $client->getProfile()->getAccount()->setEmail('d.test@duckburg.com');
        $client->getProfile()->getAccount()->setStatus(AccountStatus::ACTIVE);
        $client->getProfile()->getAccount()->setType(AccountType::USER);

        $client->setNumber(1);
        $client->setReverseNumber('asdf');
        $client->setStatus(2);
        $client->setType(3);
        $client->setTaxId('a123546');
        $client->setInfo('Some info.');

        $id = ClientMapper::create($client);
        self::assertGreaterThan(0, $client->getId());
        self::assertEquals($id, $client->getId());

        $clientR = ClientMapper::get($client->getId());
        self::assertEquals($client->getCreatedAt()->format('Y-m-d'), $clientR->getCreatedAt()->format('Y-m-d'));
        self::assertEquals($client->getProfile()->getAccount()->getName1(), $clientR->getProfile()->getAccount()->getName1());
        self::assertEquals($client->getProfile()->getAccount()->getName2(), $clientR->getProfile()->getAccount()->getName2());
        self::assertEquals($client->getProfile()->getAccount()->getName3(), $clientR->getProfile()->getAccount()->getName3());
        self::assertEquals($client->getProfile()->getAccount()->getStatus(), $clientR->getProfile()->getAccount()->getStatus());
        self::assertEquals($client->getProfile()->getAccount()->getType(), $clientR->getProfile()->getAccount()->getType());
        self::assertEquals($client->getProfile()->getAccount()->getEmail(), $clientR->getProfile()->getAccount()->getEmail());

        self::assertEquals(1, $client->getNumber());
        self::assertEquals('asdf', $client->getReverseNumber());
        self::assertEquals(2, $client->getStatus());
        self::assertEquals(3, $client->getType());
        self::assertEquals('a123546', $client->getTaxId());
        self::assertEquals('Some info.', $client->getInfo());
    }

    /**
     * @group volume
     */
    public function testVolume()
    {
        for ($i = 1; $i < 100; $i++) {
            $client = new Client();

            $client->getProfile()->getAccount()->setName1(Name::generateName(['female', 'male']));
            $client->getProfile()->getAccount()->setName2(Name::generateName(['family']));
            $client->getProfile()->getAccount()->setStatus(AccountStatus::ACTIVE);
            $client->getProfile()->getAccount()->setType(AccountType::USER);

            $client->setNumber($i + 1);
            $client->setStatus(2);
            $client->setType(3);

            $id = ClientMapper::create($client);
        }
    }
}
