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

namespace Tests\PHPUnit\phpOMS\Module;

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';

use phpOMS\Module\ModuleAbstract;

class ModuleAbstractTest extends \PHPUnit\Framework\TestCase
{
	public function testModuleAbstract()
	{
        $moduleClass = new class(null) extends ModuleAbstract {
            const MODULE_VERSION = '1.2.3';
            const MODULE_NAME = 'Test';
            const MODULE_ID = 2;
            protected static $dependencies = [1, 2];
        };

        self::assertEquals([1, 2], $moduleClass->getDependencies());
        self::assertEquals(2, $moduleClass::MODULE_ID);
        self::assertEquals('1.2.3', $moduleClass::MODULE_VERSION);
    }
}