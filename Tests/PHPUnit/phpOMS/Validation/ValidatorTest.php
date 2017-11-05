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

namespace Tests\PHPUnit\phpOMS\Validation;

use phpOMS\Log\FileLogger;
use phpOMS\Validation\Validator;

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';

class ValidatorTest extends \PHPUnit\Framework\TestCase
{
    public function testValidation()
    {
        self::assertTrue(Validator::contains('Test string contains something.', 'contains'));
        self::assertFalse(Validator::contains('Test string contains something.', 'contains2'));

        self::assertTrue(Validator::hasLength('Test string contains something.'));
        self::assertTrue(Validator::hasLength('Test string contains something.', 10, 100));
        self::assertFalse(Validator::hasLength('Test string contains something.', 100, 1000));

        self::assertTrue(Validator::hasLimit(1.23, 1.0, 2.0));
        self::assertTrue(Validator::hasLimit(1, 0, 2));
        self::assertFalse(Validator::hasLimit(3.0, 0, 2));

        self::assertTrue(Validator::isType(new FileLogger(__DIR__), '\phpOMS\Log\FileLogger'));
        self::assertFalse(Validator::isType(new FileLogger(__DIR__), '\some\namespace'));

        Validator::resetError();
        self::assertEquals('', Validator::getMessage());
        self::assertEquals(0, Validator::getErrorCode());
    }
}
