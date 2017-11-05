<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   TBD
 * @package    TBD
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */

namespace Tests\PHPUnit\phpOMS\Business\Marketing;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Business\Marketing\Metrics;

class MetricsTest extends \PHPUnit\Framework\TestCase
{
    public function testMetrics()
    {
        self::assertTrue(0.85-Metrics::getCustomerRetention(105, 20, 100) < 0.01);
    }
}
