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

namespace Tests\PHPUnit\phpOMS\Utils\Git;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Utils\Git\Branch;

class BranchTest extends \PHPUnit\Framework\TestCase
{
    public function testDefault()
    {
        $branch = new Branch();
        self::assertEquals('', $branch->getName());
    }

    public function testGetSet()
    {
        $branch = new Branch('test');
        self::assertEquals('test', $branch->getName());
    }
}
