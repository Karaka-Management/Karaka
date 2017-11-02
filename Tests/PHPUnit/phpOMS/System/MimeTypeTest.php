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

namespace Tests\PHPUnit\phpOMS\System;

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';

use phpOMS\System\MimeType;

class MimeTypeTest extends \PHPUnit\Framework\TestCase
{
    public function testEnum()
    {
        $enums = MimeType::getConstants();

        foreach ($enums as $key => $value) {
            if (stripos($value, '/') === false) {
                self::assertFalse(true);
            } 
        }

        self::assertTrue(true);
    }
}
