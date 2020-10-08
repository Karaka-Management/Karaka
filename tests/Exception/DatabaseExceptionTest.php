<?php
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace tests\Web\Exception;

require_once __DIR__ . '/../../phpOMS/Autoloader.php';

use Web\Exception\DatabaseException;

/**
 * @internal
 */
class DatabaseExceptionTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers Web\Exception\DatabaseException
     * @group framework
     */
    public function testException() : void
    {
        self::assertInstanceOf(\RuntimeException::class, new DatabaseException(''));
    }
}
