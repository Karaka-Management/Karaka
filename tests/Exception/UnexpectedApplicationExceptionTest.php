<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace tests\Web\Exception;

require_once __DIR__ . '/../../phpOMS/Autoloader.php';

use Web\Exception\UnexpectedApplicationException;

/**
 * @internal
 */
class UnexpectedApplicationExceptionTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers Web\Exception\UnexpectedApplicationException
     * @group framework
     */
    public function testException() : void
    {
        self::assertInstanceOf(\RuntimeException::class, new UnexpectedApplicationException(''));
    }
}
