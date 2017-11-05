<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   TBD
 * @package    TBD
 * @author     OMS Development Team <dev@oms.com>
 * @copyright  2013 Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */

namespace Tests\PHPUnit\Modules\ClientManagement\Models;

use Modules\ClientManagement\Models\Client;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class ClientTest extends \PHPUnit\Framework\TestCase
{
    public function testDefult()
    {
        $client = new Client();

        self::assertEquals(0, $client->getNumber());
        self::assertEmpty($client->getReverseNumber());
        self::assertEquals(0, $client->getStatus());
        self::assertEquals(0, $client->getType());
        self::assertEmpty($client->getTaxId());
        self::assertEmpty($client->getInfo());
        self::assertInstanceOf('\DateTime', $client->getCreatedAt());
    }

    public function testSetGet()
    {
        $client = new Client();

        $client->setNumber(1);
        self::assertEquals(1, $client->getNumber());

        $client->setReverseNumber('asdf');
        self::assertEquals('asdf', $client->getReverseNumber());

        $client->setStatus(2);
        self::assertEquals(2, $client->getStatus());

        $client->setType(3);
        self::assertEquals(3, $client->getType());

        $client->setTaxId('a123456');
        self::assertEquals('a123456', $client->getTaxId());

        $client->setInfo('Some info.');
        self::assertEquals('Some info.', $client->getInfo());
    }
}
