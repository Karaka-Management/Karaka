<?php
/**
 * Orange Management
 *
 * PHP Version 7.2
 *
 * @package    tests
 * @copyright  2013 Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */

namespace phpOMS\tests\phpOMS\Model\Message;

use phpOMS\Model\Message\FormValidation;

class FormValidationTest extends \PHPUnit\Framework\TestCase
{

    public function testAttributes()
    {
        $obj = new FormValidation([]);
        self::assertInstanceOf('\phpOMS\Model\Message\FormValidation', $obj);

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
        self::assertEquals(\json_encode(['type' => 'validation', 'validation' => $arr]), $obj->serialize());
        self::assertEquals(['type' => 'validation', 'validation' => $arr], $obj->jsonSerialize());

        $obj2 = new FormValidation();
        $obj2->unserialize($obj->serialize());
        self::assertEquals($obj, $obj2);
    }
}
