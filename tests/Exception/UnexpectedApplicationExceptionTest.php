<?php
/**
 * Jingga
 *
 * PHP Version 8.2
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
#[\PHPUnit\Framework\Attributes\CoversClass(\Web\Exception\UnexpectedApplicationException::class)]
class UnexpectedApplicationExceptionTest extends \PHPUnit\Framework\TestCase
{
    #[\PHPUnit\Framework\Attributes\Group('framework')]
    public function testException() : void
    {
        self::assertInstanceOf(\RuntimeException::class, new UnexpectedApplicationException(''));
    }
}
