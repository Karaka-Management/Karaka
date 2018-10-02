<?php
/**
 * Orange Management
 *
 * PHP Version 7.2
 *
 * @package    tests
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */

namespace tests\Web\Exception;

require_once __DIR__ . '/../../phpOMS/Autoloader.php';

use Web\Exception\UnexpectedApplicationException;

class UnexpectedApplicationExceptionTest extends \PHPUnit\Framework\TestCase
{
    public function testException()
    {
        self::assertInstanceOf(\RuntimeException::class, new UnexpectedApplicationException(''));
    }
}
