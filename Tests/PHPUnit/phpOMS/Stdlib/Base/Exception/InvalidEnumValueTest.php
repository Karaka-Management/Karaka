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

namespace Tests\PHPUnit\phpOMS\Stdlib\Base\Exception;

require_once __DIR__ . '/../../../../../../phpOMS/Autoloader.php';

use phpOMS\Stdlib\Base\Exception\InvalidEnumValue;

class InvalidEnumValueTest extends \PHPUnit\Framework\TestCase
{
    public function testException()
    {
        self::assertInstanceOf(\UnexpectedValueException::class, new InvalidEnumValue(''));
    }
}
