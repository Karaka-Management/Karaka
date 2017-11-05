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

namespace Tests\PHPUnit\phpOMS\Business\Marketing;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';

use phpOMS\Business\Marketing\NetPromoterScore;

class NetPromoterScoreTest extends \PHPUnit\Framework\TestCase
{
    public function testDefault()
    {
        $nps = new NetPromoterScore();

        self::assertEquals(0, $nps->getScore());
    }

    public function testGetSet()
    {
        $nps = new NetPromoterScore();

        for ($i = 0; $i < 10; $i++) {
            $nps->add(mt_rand(0, 6));
        }

        for ($i = 0; $i < 30; $i++) {
            $nps->add(mt_rand(7, 8));
        }

        for ($i = 0; $i < 60; $i++) {
            $nps->add(mt_rand(9, 10));
        }

        self::assertEquals(50, $nps->getScore());
        self::assertEquals(10, $nps->countDetractors());
        self::assertEquals(30, $nps->countPassives());
        self::assertEquals(60, $nps->countPromoters());
    }
}
