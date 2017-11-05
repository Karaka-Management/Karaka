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

namespace Tests\PHPUnit\Modules\Media\Models;

use Modules\Media\Models\Collection;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class CollectionTest extends \PHPUnit\Framework\TestCase
{
    public function testDefult()
    {
        $media = new Collection();


        self::assertEquals(0, $media->getId());
        self::assertEquals(0, $media->getCreatedBy());
        self::assertEquals((new \DateTime('now'))->format('Y-m-d'), $media->getCreatedAt()->format('Y-m-d'));
        self::assertEquals('collection', $media->getExtension());
        self::assertEquals('', $media->getPath());
        self::assertEquals('', $media->getName());
        self::assertEquals('', $media->getDescription());
        self::assertEquals(0, $media->getSize());
        self::assertEquals(false, $media->isVersioned());
        self::assertEquals([], $media->getSources());
    }

    public function testSetGet()
    {
        $media = new Collection();

        $media->setCreatedBy(1);
        self::assertEquals(1, $media->getCreatedBy());

        $media->setCreatedAt($date = new \DateTime('2000-05-05'));
        self::assertEquals($date->format('Y-m-d'), $media->getCreatedAt()->format('Y-m-d'));

        $media->setExtension('pdf');
        self::assertEquals('collection', $media->getExtension());

        $media->setPath('/home/root');
        self::assertEquals('/home/root', $media->getPath());

        $media->setName('Report');
        self::assertEquals('Report', $media->getName());

        $media->setDescription('This is a description');
        self::assertEquals('This is a description', $media->getDescription());

        $media->setSize(11);
        self::assertEquals(11, $media->getSize());

        $media->setVersioned(true);
        self::assertEquals(false, $media->isVersioned());

        $media->setSources([1, 2, 3]);
        self::assertEquals([1, 2, 3], $media->getSources());

        $media->addSource(4);
        self::assertEquals([1, 2, 3, 4], $media->getSources());
    }
}
