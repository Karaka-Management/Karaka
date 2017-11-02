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
 * @link       http://orange-management.com
 */

namespace Tests\PHPUnit\phpOMS\System\File;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\System\File\PermissionException;

class PermissionExceptionTest extends \PHPUnit\Framework\TestCase
{
    public function testConstructor()
    {
        $e = new PermissionException('test.file');
        self::assertContains('test.file', $e->getMessage());
        self::assertEquals(0, $e->getCode());
        $this->isInstanceOf('\RuntimeException');
    }
}
