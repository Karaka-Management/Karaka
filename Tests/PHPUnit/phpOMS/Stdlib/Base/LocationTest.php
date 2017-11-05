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

use phpOMS\Stdlib\Base\Location;
use phpOMS\Stdlib\Base\AddressType;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

class LocationTest extends \PHPUnit\Framework\TestCase
{
    public function testAttributes()
    {
        $location = new Location();
        self::assertObjectHasAttribute('postal', $location);
        self::assertObjectHasAttribute('city', $location);
        self::assertObjectHasAttribute('country', $location);
        self::assertObjectHasAttribute('address', $location);
        self::assertObjectHasAttribute('state', $location);
        self::assertObjectHasAttribute('geo', $location);
    }

    public function testDefault()
    {
        $expected = [
            'postal'  => '',
            'city'    => '',
            'country' => '',
            'address' => '',
            'state'   => '',
            'geo'     => [
                'lat'  => 0,
                'long' => 0,
            ],
        ];

        $location = new Location();
        self::assertEquals('', $location->getPostal());
        self::assertEquals('', $location->getCity());
        self::assertEquals('', $location->getCountry());
        self::assertEquals('', $location->getAddress());
        self::assertEquals('', $location->getState());
        self::assertEquals(0, $location->getId());
        self::assertEquals(AddressType::HOME, $location->getType());
        self::assertEquals(['lat' => 0, 'long' => 0], $location->getGeo());
        self::assertEquals($expected, $location->toArray());
        self::assertEquals($expected, $location->jsonSerialize());
    }

    public function testGetSet()
    {
        $expected = [
            'postal'  => '0123456789',
            'city'    => 'city',
            'country' => 'Country',
            'address' => 'Some address here',
            'state'   => 'This is a state 123',
            'geo'     => [
                'lat'  => 12.1,
                'long' => 11.2,
            ],
        ];

        $location = new Location();

        $location->setPostal('0123456789');
        $location->setType(AddressType::BUSINESS);
        $location->setCity('city');
        $location->setCountry('Country');
        $location->setAddress('Some address here');
        $location->setState('This is a state 123');
        $location->setGeo(['lat' => 12.1, 'long' => 11.2,]);

        self::assertEquals(AddressType::BUSINESS, $location->getType());
        self::assertEquals('0123456789', $location->getPostal());
        self::assertEquals('city', $location->getCity());
        self::assertEquals('Country', $location->getCountry());
        self::assertEquals('Some address here', $location->getAddress());
        self::assertEquals('This is a state 123', $location->getState());
        self::assertEquals(['lat' => 12.1, 'long' => 11.2], $location->getGeo());
        self::assertEquals($expected, $location->toArray());
        self::assertEquals($expected, $location->jsonSerialize());
    }
}
