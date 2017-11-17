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

use phpOMS\Utils\Git\Tag;

class TagTest extends \PHPUnit\Framework\TestCase
{
    public function testDefault()
    {
        $tag = new Tag();
        self::assertEquals('', $tag->getMessage());
        self::assertEquals('', $tag->getName());
    }

    public function testGetSet()
    {
        $tag = new Tag('test');
        self::assertEquals('test', $tag->getName());

        $tag->setMessage('msg');
        self::assertEquals('msg', $tag->getMessage());
    }
}
