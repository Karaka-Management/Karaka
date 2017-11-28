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

use Modules\Media\Models\Media;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class MediaTest extends \PHPUnit\Framework\TestCase
{
    public function testDefult()
    {
        $media = new Media();

        self::assertEquals(0, $media->getId());
        self::assertEquals(0, $media->getCreatedBy());
        self::assertEquals((new \DateTime('now'))->format('Y-m-d'), $media->getCreatedAt()->format('Y-m-d'));
        self::assertEquals('', $media->getExtension());
        self::assertEquals('', $media->getPath());
        self::assertFalse($media->isAbsolute());
        self::assertEquals('', $media->getName());
        self::assertEquals('', $media->getDescription());
        self::assertEquals(0, $media->getSize());
        self::assertEquals(false, $media->isVersioned());
    }

    public function testSetGet()
    {
        $media = new Media();

        $media->setCreatedBy(1);
        self::assertEquals(1, $media->getCreatedBy());

        $media->setExtension('pdf');
        self::assertEquals('pdf', $media->getExtension());

        $media->setPath('/home/root');
        self::assertEquals('/home/root', $media->getPath());

        $media->setAbsolute(true);
        self::assertTrue($media->isAbsolute());

        $media->setName('Report');
        self::assertEquals('Report', $media->getName());

        $media->setDescription('This is a description');
        self::assertEquals('This is a description', $media->getDescription());

        $media->setSize(11);
        self::assertEquals(11, $media->getSize());

        $media->setVersioned(true);
        self::assertEquals(true, $media->isVersioned());
    }
}
