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

namespace Tests\PHPUnit\Modules\Reporter\Models;

use Modules\Reporter\Models\ReporterStatus;
use Modules\Reporter\Models\Template;
use Modules\Reporter\Models\TemplateDataType;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class TemplateTest extends \PHPUnit\Framework\TestCase
{
    public function testDefult()
    {
        $template = new Template();

        self::assertEquals(0, $template->getId());
        self::assertEquals(0, $template->getCreatedBy());
        self::assertEquals((new \DateTime('now'))->format('Y-m-d'), $template->getCreatedAt()->format('Y-m-d'));
        self::assertEquals('', $template->getName());
        self::assertEquals(ReporterStatus::INACTIVE, $template->getStatus());
        self::assertEquals('', $template->getDescription());
        self::assertEquals([], $template->getExpected());
        self::assertEquals(0, $template->getSource());
        self::assertFalse($template->isStandalone());
        self::assertEquals(TemplateDataType::OTHER, $template->getDatatype());
    }

    public function testSetGet()
    {
        $template = new Template();

        $template->setCreatedBy(1);
        self::assertEquals(1, $template->getCreatedBy());

        $template->setCreatedAt($date = new \DateTime('2000-05-05'));
        self::assertEquals($date->format('Y-m-d'), $template->getCreatedAt()->format('Y-m-d'));

        $template->setName('Title');
        self::assertEquals('Title', $template->getName());

        $template->setStatus(ReporterStatus::ACTIVE);
        self::assertEquals(ReporterStatus::ACTIVE, $template->getStatus());

        $template->setStandalone(true);
        self::assertTrue($template->isStandalone());

        $template->setDescription('Description');
        self::assertEquals('Description', $template->getDescription());

        $template->setExpected(['source1.csv', 'source2.csv']);
        self::assertEquals(['source1.csv', 'source2.csv'], $template->getExpected());

        $template->setSource(4);
        self::assertEquals(4, $template->getSource());

        $template->setDatatype(TemplateDataType::GLOBAL_DB);
        self::assertEquals(TemplateDataType::GLOBAL_DB, $template->getDatatype());
    }
}
