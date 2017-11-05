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

namespace Tests\PHPUnit\Model\Message;

use Model\Message\Reload;

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../config.php';

class ReloadTest extends \PHPUnit\Framework\TestCase
{

    public function testAttributes()
    {
        $obj = new Reload();
        self::assertInstanceOf('\Model\Message\Reload', $obj);

        /* Testing members */
        self::assertObjectHasAttribute('delay', $obj);
    }

    public function testDefault()
    {
        $obj = new Reload();

        /* Testing default values */
        self::assertEquals(0, $obj->toArray()['time']);
    }

    public function testSetGet()
    {
        $obj = new Reload(5);

        self::assertEquals(['type' => 'reload', 'time' => 5], $obj->toArray());
        self::assertEquals(json_encode(['type' => 'reload', 'time' => 5]), $obj->serialize());
        self::assertEquals(['type' => 'reload', 'time' => 5], $obj->jsonSerialize());

        $obj->setDelay(6);
        self::assertEquals(['type' => 'reload', 'time' => 6], $obj->toArray());
    }
}