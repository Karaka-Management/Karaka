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

namespace Tests\PHPUnit\phpOMS\Validation\Finance;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Validation\Finance\IbanErrorType;

class IbanErrorTypeTest extends \PHPUnit\Framework\TestCase
{
    public function testEnums()
    {
        self::assertEquals(5, count(IbanErrorType::getConstants()));
        self::assertEquals(1, IbanErrorType::INVALID_COUNTRY);
        self::assertEquals(2, IbanErrorType::INVALID_LENGTH);
        self::assertEquals(4, IbanErrorType::INVALID_CHECKSUM);
        self::assertEquals(8, IbanErrorType::EXPECTED_ZERO);
        self::assertEquals(16, IbanErrorType::EXPECTED_NUMERIC);
    }
}
