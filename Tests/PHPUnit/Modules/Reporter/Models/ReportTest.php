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

namespace Tests\PHPUnit\Modules\Reporter\Models;

use Modules\Reporter\Models\Report;
use Modules\Reporter\Models\ReporterStatus;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class ReportTest extends \PHPUnit\Framework\TestCase
{
    public function testDefult()
    {
        $report = new Report();

        self::assertEquals(0, $report->getId());
        self::assertEquals(0, $report->getCreatedBy());
        self::assertEquals((new \DateTime('now'))->format('Y-m-d'), $report->getCreatedAt()->format('Y-m-d'));
        self::assertEquals('', $report->getTitle());
        self::assertEquals(ReporterStatus::INACTIVE, $report->getStatus());
        self::assertEquals('', $report->getDescription());
        self::assertEquals(0, $report->getTemplate());
        self::assertEquals(0, $report->getSource());
    }

    public function testSetGet()
    {
        $report = new Report();

        $report->setCreatedBy(1);
        self::assertEquals(1, $report->getCreatedBy());

        $report->setTitle('Title');
        self::assertEquals('Title', $report->getTitle());

        $report->setStatus(ReporterStatus::ACTIVE);
        self::assertEquals(ReporterStatus::ACTIVE, $report->getStatus());

        $report->setDescription('Description');
        self::assertEquals('Description', $report->getDescription());

        $report->setTemplate(11);
        self::assertEquals(11, $report->getTemplate());

        $report->setSource(4);
        self::assertEquals(4, $report->getSource());
    }
}
