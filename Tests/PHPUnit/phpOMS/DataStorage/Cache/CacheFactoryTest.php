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

namespace Tests\PHPUnit\phpOMS\DataStorage\Cache;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\DataStorage\Cache\CacheFactory;

class CacheFactoryTest extends \PHPUnit\Framework\TestCase
{
	public function testCreate()
	{
		self::assertInstanceOf(
			\phpOMS\DataStorage\Cache\FileCache::class, 
			CacheFactory::create(['type' => 'file', 'path' => 'Cache'])
		);
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testInvalidCacheType()
	{
		CacheFactory::create(['type' => 'invalid', 'path' => 'Cache']);
	}
}

