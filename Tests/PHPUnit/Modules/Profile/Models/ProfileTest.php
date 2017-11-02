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

namespace Tests\PHPUnit\Modules\Profile\Models;

use Modules\Profile\Models\Profile;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class ProfileTest extends \PHPUnit\Framework\TestCase
{
    public function testDefult()
    {
        $profile = new Profile();

        self::assertEquals(0, $profile->getId());
        self::assertInstanceOf('\Modules\Media\Models\Media', $profile->getImage());
        self::assertInstanceOf('\DateTime', $profile->getBirthday());
    }

    public function testSetGet()
    {
        $profile = new Profile();

        $profile->setBirthday($date = new \DateTime('now'));
        self::assertEquals($date, $profile->getBirthday());
    }
}
