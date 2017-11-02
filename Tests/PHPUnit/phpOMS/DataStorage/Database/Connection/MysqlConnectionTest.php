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

namespace Tests\PHPUnit\phpOMS\DataStorage\Database\Connection;

require_once __DIR__ . '/../../../../../../phpOMS/Autoloader.php';

use phpOMS\DataStorage\Database\Connection\MysqlConnection;
use phpOMS\DataStorage\Database\DatabaseStatus;

class MysqlConnectionTest extends \PHPUnit\Framework\TestCase
{
	public function testConnect()
	{
		$mysql = new MysqlConnection($GLOBALS['CONFIG']['db']['core']['masters']['admin']);

		self::assertEquals(DatabaseStatus::OK, $mysql->getStatus());
		self::assertEquals($GLOBALS['CONFIG']['db']['core']['masters']['admin']['database'], $mysql->getDatabase());
		self::assertEquals($GLOBALS['CONFIG']['db']['core']['masters']['admin']['host'], $mysql->getHost());
		self::assertEquals((int) $GLOBALS['CONFIG']['db']['core']['masters']['admin']['port'], $mysql->getPort());
		self::assertInstanceOf('\phpOMS\DataStorage\Database\Query\Grammar\MysqlGrammar', $mysql->getGrammar());
	
	}

	/**
	 * @expectedException \phpOMS\DataStorage\Database\Exception\InvalidConnectionConfigException
	 */
	public function testInvalidDatabaseType()
	{
		$db = $GLOBALS['CONFIG']['db']['core']['masters']['admin'];
		unset($db['db']);

		$mysql = new MysqlConnection($db);
	}

	/**
	 * @expectedException \phpOMS\DataStorage\Database\Exception\InvalidConnectionConfigException
	 */
	public function testInvalidHost()
	{
		$db = $GLOBALS['CONFIG']['db']['core']['masters']['admin'];
		unset($db['host']);

		$mysql = new MysqlConnection($db);
	}

	/**
	 * @expectedException \phpOMS\DataStorage\Database\Exception\InvalidConnectionConfigException
	 */
	public function testInvalidPort()
	{
		$db = $GLOBALS['CONFIG']['db']['core']['masters']['admin'];
		unset($db['port']);

		$mysql = new MysqlConnection($db);
	}

	/**
	 * @expectedException \phpOMS\DataStorage\Database\Exception\InvalidConnectionConfigException
	 */
	public function testInvalidDatabase()
	{
		$db = $GLOBALS['CONFIG']['db']['core']['masters']['admin'];
		unset($db['database']);

		$mysql = new MysqlConnection($db);
	}

	/**
	 * @expectedException \phpOMS\DataStorage\Database\Exception\InvalidConnectionConfigException
	 */
	public function testInvalidLogin()
	{
		$db = $GLOBALS['CONFIG']['db']['core']['masters']['admin'];
		unset($db['login']);

		$mysql = new MysqlConnection($db);
	}

	/**
	 * @expectedException \phpOMS\DataStorage\Database\Exception\InvalidConnectionConfigException
	 */
	public function testInvalidPassword()
	{
		$db = $GLOBALS['CONFIG']['db']['core']['masters']['admin'];
		unset($db['password']);

		$mysql = new MysqlConnection($db);
	}
}
