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
 * @link       http://orange-management.com
 */

namespace Tests\PHPUnit\Modules\Tasks\Models;

use Modules\Editor\Models\EditorDoc;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class EditorDocTest extends \PHPUnit\Framework\TestCase
{
    public function testDefult()
    {
        $doc = new EditorDoc();

        self::assertEquals(0, $doc->getId());
        self::assertEquals(0, $doc->getCreatedBy());
        self::assertEquals('', $doc->getTitle());
        self::assertEquals('', $doc->getContent());
        self::assertEquals('', $doc->getPlain());
        self::assertEquals((new \DateTime('now'))->format('Y-m-d'), $doc->getCreatedAt()->format('Y-m-d'));
    }

    public function testSetGet()
    {
        $doc = new EditorDoc();

        $doc->setCreatedBy(1);
        self::assertEquals(1, $doc->getCreatedBy());

        $doc->setTitle('Title');
        self::assertEquals('Title', $doc->getTitle());

        $doc->setContent('Content');
        self::assertEquals('Content', $doc->getContent());

        $doc->setPlain('Plain');
        self::assertEquals('Plain', $doc->getPlain());

        $doc->setPath('/some/path');
        self::assertEquals('/some/path', $doc->getPath());

        $doc->setCreatedAt($data = new \DateTime('2001-05-05'));
        self::assertEquals($data, $doc->getCreatedAt());

        $arr = [
            'id' => 0,
            'title' => $doc->getTitle(),
            'plain' => $doc->getPlain(),
            'content' => $doc->getContent(),
            'createdAt' => $doc->getCreatedAt()->format('Y-m-d H:i:s'),
            'createdBy' => $doc->getCreatedBy(),
        ];
        self::assertEquals($arr, $doc->toArray());
        self::assertEquals($arr, $doc->jsonSerialize());
        self::assertEquals(json_encode($arr), $doc->__toString());
    }
}
