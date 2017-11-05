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

namespace Tests\PHPUnit\phpOMS\Utils\IO\Zip;

require_once __DIR__ . '/../../../../../../phpOMS/Autoloader.php';

use phpOMS\Utils\IO\Zip\Zip;

class ZipTest extends \PHPUnit\Framework\TestCase
{
	public function testZip()
	{
		self::assertTrue(Zip::pack(
			[
				__DIR__ . '/test a.txt' => 'test a.txt',
				__DIR__ . '/test b.md' => 'test b.md',
				__DIR__ . '/test' => 'test',
			],
			__DIR__ . '/test.zip'
		));

		self::assertTrue(file_exists(__DIR__ . '/test.zip'));

		self::assertFalse(Zip::pack(
			[
				__DIR__ . '/test a.txt' => 'test a.txt',
				__DIR__ . '/test b.txt' => 'test b.txt',
			],
			__DIR__ . '/test.zip',
			false
		));

		$a = file_get_contents(__DIR__ . '/test a.txt');
		$b = file_get_contents(__DIR__ . '/test b.md');
		$c = file_get_contents(__DIR__ . '/test/test c.txt');
		$d = file_get_contents(__DIR__ . '/test/test d.txt');
		$e = file_get_contents(__DIR__ . '/test/sub/test e.txt');

		unlink(__DIR__ . '/test a.txt');
		unlink(__DIR__ . '/test b.md');
		unlink(__DIR__ . '/test/test c.txt');
		unlink(__DIR__ . '/test/test d.txt');
		unlink(__DIR__ . '/test/sub/test e.txt');
		rmdir(__DIR__ . '/test/sub');
		rmdir(__DIR__ . '/test');

		self::assertFalse(file_exists(__DIR__ . '/test a.txt'));
		self::assertFalse(file_exists(__DIR__ . '/test b.md'));
		self::assertFalse(file_exists(__DIR__ . '/test/test c.txt'));
		self::assertFalse(file_exists(__DIR__ . '/test/test d.txt'));
		self::assertFalse(file_exists(__DIR__ . '/test/sub/test e.txt'));
		self::assertFalse(file_exists(__DIR__ . '/test/sub'));
		self::assertFalse(file_exists(__DIR__ . '/test'));
		
		self::assertTrue(Zip::unpack(__DIR__ . '/test.zip', __DIR__));

		self::assertTrue(file_exists(__DIR__ . '/test a.txt'));
		self::assertTrue(file_exists(__DIR__ . '/test b.md'));
		self::assertTrue(file_exists(__DIR__ . '/test/test c.txt'));
		self::assertTrue(file_exists(__DIR__ . '/test/test d.txt'));
		self::assertTrue(file_exists(__DIR__ . '/test/sub/test e.txt'));
		self::assertTrue(file_exists(__DIR__ . '/test/sub'));
		self::assertTrue(file_exists(__DIR__ . '/test'));

		self::assertEquals($a, file_get_contents(__DIR__ . '/test a.txt'));
		self::assertEquals($b, file_get_contents(__DIR__ . '/test b.md'));
		self::assertEquals($c, file_get_contents(__DIR__ . '/test/test c.txt'));
		self::assertEquals($d, file_get_contents(__DIR__ . '/test/test d.txt'));
		self::assertEquals($e, file_get_contents(__DIR__ . '/test/sub/test e.txt'));

		unlink(__DIR__ . '/test.zip');
		self::assertFalse(file_exists(__DIR__ . '/test.zip'));
		self::assertFalse(Zip::unpack(__DIR__ . '/test.zip', __DIR__));
	}
}
