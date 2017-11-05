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
namespace Tests\PHPUnit\phpOMS\Dispatcher;

class TestController
{
    public function testFunction($req, $resp, $data = null) 
    {
        return true;
    }

    public static function testFunctionStatic($req, $resp, $data = null) 
    {
        return true;
    }
}