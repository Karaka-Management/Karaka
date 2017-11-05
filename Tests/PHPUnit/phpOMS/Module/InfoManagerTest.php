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

use phpOMS\Module\InfoManager;

class InfoManagerTest extends \PHPUnit\Framework\TestCase
{
	public function testInfoManager()
	{
		$info = new InfoManager(__Dir__ . '/info-test.json');
		$info->load();

		$jarray = json_decode(file_get_contents(__Dir__ . '/info-test.json'), true);

		self::assertEquals($jarray, $info->get());
		self::assertEquals($jarray['name']['internal'], $info->getInternalName());
		self::assertEquals($jarray['name']['external'], $info->getExternalName());
		self::assertEquals($jarray['category'], $info->getCategory());
		self::assertEquals($jarray['dependencies'], $info->getDependencies());
		self::assertEquals($jarray['providing'], $info->getProviding());
		self::assertEquals($jarray['directory'], $info->getDirectory());
		self::assertEquals($jarray['version'], $info->getVersion());
		self::assertEquals($jarray['load'], $info->getLoad());

		$info->set('/name/internal', 'ABC');
		self::assertEquals('ABC', $info->getInternalName());
		$info->update();

		$info2 = new InfoManager(__Dir__ . '/info-test.json');
		$info2->load();
		self::assertEquals($info->getInternalName(), $info2->getInternalName());

		$info->set('/name/internal', $jarray['name']['internal']);
		$info->update();
	}

	/**
	 * @expectedException \phpOMS\System\File\PathException
	 */
	public function testInvalidPathLoad()
	{
		$info = new InfoManager(__Dir__ . '/invalid.json');
		$info->load();
	}

	/**
	 * @expectedException \phpOMS\System\File\PathException
	 */
	public function testInvalidPathUpdate()
	{
		$info = new InfoManager(__Dir__ . '/invalid.json');
		$info->update();
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testInvalidDataSet()
	{
		$info = new InfoManager(__Dir__ . '/info-test.json');
		$info->load();

		$testObj = new class { public $test = 1; public function test() { echo $this->test; }};

		$info->set('/name/internal', $testObj);
	}
}
