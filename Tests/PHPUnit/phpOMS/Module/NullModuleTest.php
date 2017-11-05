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

namespace Tests\PHPUnit\phpOMS\Module;

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';

use phpOMS\Module\NullModule;
use phpOMS\ApplicationAbstract;

class NullModuleTest extends \PHPUnit\Framework\TestCase
{
    public function testModule()
    {
        $app = new class extends ApplicationAbstract
        {
        };

        self::assertInstanceOf('\phpOMS\Module\ModuleAbstract', new NullModule($app));
    }
}
