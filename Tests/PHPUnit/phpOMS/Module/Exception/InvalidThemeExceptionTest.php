<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   TBD
 * @package    TBD
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */

namespace Tests\PHPUnit\phpOMS\Module\Exception;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Module\Exception\InvalidThemeException;

class InvalidThemeExceptionTest extends \PHPUnit\Framework\TestCase
{
    public function testException()
	{
		self::assertInstanceOf(\UnexpectedValueException::class, new InvalidThemeException(''));
	}
}
