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

namespace Tests\PHPUnit\phpOMS\Stdlib\Base;

use phpOMS\Stdlib\Base\Address;
use phpOMS\Stdlib\Base\Location;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

class AddressTest extends \PHPUnit\Framework\TestCase
{
    public function testAttributes()
    {
        $address = new Address();
        self::assertObjectHasAttribute('recipient', $address);
        self::assertObjectHasAttribute('fao', $address);
        self::assertObjectHasAttribute('location', $address);
    }

    public function testDefault()
    {
        $expected = [
            'recipient' => '',
            'fao' => '',
            'location' => [
                'postal' => '',
                'city' => '',
                'country' => '',
                'address' => '',
                'state' => '',
                'geo' => [
                    'lat' => 0,
                    'long' => 0
                ],
            ]
        ];

        $address = new Address();
        self::assertEquals('', $address->getRecipient());
        self::assertEquals('', $address->getFAO());
        self::assertInstanceOf('\phpOMS\Stdlib\Base\Location', $address->getLocation());
        self::assertEquals($expected, $address->toArray());
        self::assertEquals($expected, $address->jsonSerialize());
    }

    public function testGetSet()
    {
        $expected = [
            'recipient' => 'recipient',
            'fao' => 'fao',
            'location' => [
                'postal' => '',
                'city' => '',
                'country' => '',
                'address' => '',
                'state' => '',
                'geo' => [
                    'lat' => 0,
                    'long' => 0
                ],
            ]
        ];

        $address = new Address();
        $address->setFAO('fao');
        $address->setRecipient('recipient');
        $address->setLocation(new Location());

        self::assertEquals('recipient', $address->getRecipient());
        self::assertEquals('fao', $address->getFAO());
        self::assertInstanceOf('\phpOMS\Stdlib\Base\Location', $address->getLocation());
        self::assertEquals($expected, $address->toArray());
        self::assertEquals($expected, $address->jsonSerialize());
    }
}
