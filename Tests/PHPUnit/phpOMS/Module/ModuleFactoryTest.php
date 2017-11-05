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

use phpOMS\ApplicationAbstract;
use phpOMS\Module\ModuleFactory;

class ModuleFactoryTest extends \PHPUnit\Framework\TestCase
{
	public function testFactory()
	{
		self::assertInstanceOf(\Modules\Admin\Controller::class, ModuleFactory::getInstance('Admin', new class extends ApplicationAbstract {}));
	}
}
