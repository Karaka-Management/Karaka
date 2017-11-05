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

namespace Tests\PHPUnit\phpOMS\DataStorage\Cookie;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\DataStorage\Cookie\CookieJar;
use phpOMS\DataStorage\LockException;

class CookieJarTest extends \PHPUnit\Framework\TestCase
{
    public function testDefault()
    {
        $jar = new CookieJar();

        self::assertFalse(CookieJar::isLocked());
        self::assertFalse($jar->delete('abc'));
        self::assertFalse($jar->delete('asd'));
    }

    public function testCookie()
    {
        $jar = new CookieJar();

        self::assertTrue($jar->set('test', 'value'));
        self::assertFalse($jar->set('test', 'value', 86400, '/', null, false, true, false));
        self::assertTrue($jar->set('test2', 'value2', 86400, '/', null, false, true, false));
        self::assertTrue($jar->set('test3', 'value3', 86400, '/', null, false, true, false));

        // header already set
        //self::assertTrue($jar->delete('test2'));
        //self::assertFalse($jar->delete('test2'));

        self::assertTrue($jar->remove('test2'));
        self::assertFalse($jar->remove('test2'));
    }

    /**
     * @expectedException \phpOMS\DataStorage\LockException
     */
    public function testDeleteLocked()
    {
        $jar = new CookieJar();
        self::assertTrue($jar->set('test', 'value'));

        CookieJar::lock();
        $jar->delete('test');
    }

    /**
     * @expectedException \phpOMS\DataStorage\LockException
     */
    public function testSaveLocked()
    {
        CookieJar::lock();

        $jar = new CookieJar();
        $jar->save();
    }
}
