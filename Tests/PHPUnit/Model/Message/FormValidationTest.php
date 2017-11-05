<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   TBD
 * @package    TBD
 * @author     OMS Development Team <dev@oms.com>
 * @copyright  2013 Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */

namespace Tests\PHPUnit\Model\Message;

use Model\Message\FormValidation;

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../config.php';

class FormValidationTest extends \PHPUnit\Framework\TestCase
{

    public function testAttributes()
    {
        $obj = new FormValidation([]);
        self::assertInstanceOf('\Model\Message\FormValidation', $obj);

        /* Testing members */
        self::assertObjectHasAttribute('validation', $obj);
    }

    public function testDefault()
    {
        $obj = new FormValidation([]);

        /* Testing default values */
        self::assertEmpty($obj->toArray()['validation']);
    }

    public function testSetGet()
    {
        $arr = ['a' => true, 'b' => false];
        $obj = new FormValidation($arr);

        self::assertEquals(['type' => 'validation', 'validation' => $arr], $obj->toArray());
        self::assertEquals(json_encode(['type' => 'validation', 'validation' => $arr]), $obj->serialize());
        self::assertEquals(['type' => 'validation', 'validation' =>  $arr], $obj->jsonSerialize());
    }
}