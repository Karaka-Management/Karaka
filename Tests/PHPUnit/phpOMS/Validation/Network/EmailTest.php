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

namespace Tests\PHPUnit\phpOMS\Validation\Network;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Validation\Network\Email;

class EmailTest extends \PHPUnit\Framework\TestCase
{
    public function testValidation()
    {
        self::assertTrue(Email::isValid('test.string@email.com'));
        self::assertFalse(Email::isValid('test.string@email'));
        self::assertTrue(Email::isValid('test.string+1234@email.com'));
    }
}
