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

use phpOMS\Asset\AssetManager;

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';

class AssetManagerTest extends \PHPUnit\Framework\TestCase
{
    public function testAttributes()
    {
        $manager = new AssetManager();
        self::assertInstanceOf('\phpOMS\Asset\AssetManager', $manager);

        /* Testing members */
        self::assertObjectHasAttribute('assets', $manager);
    }

    public function testDefault()
    {
        $manager = new AssetManager();

        /* Testing default values */
        self::assertNull($manager->get('myAsset'));
        self::assertEquals(0, $manager->count());
    }

    public function testSetGet()
    {
        $manager = new AssetManager();

        /* Test set/get/count */
        $manager->set('first', 'FirstUri');
        $set = $manager->set('myAsset', 'AssetUri');
        self::assertTrue($set);
        self::assertEquals('AssetUri', $manager->get('myAsset'));
        self::assertEquals(2, $manager->count());

        $set = $manager->set('myAsset', 'AssetUri2', false);
        self::assertFalse($set);
        self::assertEquals('AssetUri', $manager->get('myAsset'));
        self::assertEquals(2, $manager->count());

        $set = $manager->set('myAsset', 'AssetUri2');
        self::assertTrue($set);
        self::assertEquals('AssetUri2', $manager->get('myAsset'));
        self::assertEquals(2, $manager->count());

        $set = $manager->set('myAsset', 'AssetUri3', true);
        self::assertTrue($set);
        self::assertEquals('AssetUri3', $manager->get('myAsset'));
        self::assertEquals(2, $manager->count());

        /* Test remove */
        $rem = $manager->remove('myAsset');
        self::assertTrue($rem);
        self::assertEquals(1, $manager->count());

        self::assertNull($manager->get('myAsset'));

        $rem = $manager->remove('myAsset');
        self::assertFalse($rem);
        self::assertEquals(1, $manager->count());

    }
}
