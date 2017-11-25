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

use Modules\Auditor\Models\Audit;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class AuditTest extends \PHPUnit\Framework\TestCase
{
    public function testDefault()
    {
        $audit = new Audit();
        self::assertEquals(0, $audit->getType());
        self::assertEquals(0, $audit->getSubType());
        self::assertEquals(0, $audit->getModule());
        self::assertEquals('', $audit->getRef());
        self::assertEquals('', $audit->getContent());
        self::assertEquals('', $audit->getOld());
        self::assertEquals('', $audit->getNew());
        self::assertEquals(0, $audit->getCreatedBy());
        self::assertInstanceOf('\DateTime', $audit->getCreatedAt());
    }

    public function testSetGet()
    {
        $audit = new Audit();
        
        $audit->setType(1);
        self::assertEquals(1, $audit->getType());

        $audit->setSubType(2);
        self::assertEquals(2, $audit->getSubType());

        $audit->setModule(3);
        self::assertEquals(3, $audit->getModule());

        $audit->setRef('test');
        self::assertEquals('test', $audit->getRef());

        $audit->setContent('content');
        self::assertEquals('content', $audit->getContent());

        $audit->setOld('old');
        self::assertEquals('old', $audit->getOld());

        $audit->setNew('new');
        self::assertEquals('new', $audit->getNew());

        $audit->setCreatedBy(99);
        self::assertEquals(99, $audit->getCreatedBy());
    }

}
