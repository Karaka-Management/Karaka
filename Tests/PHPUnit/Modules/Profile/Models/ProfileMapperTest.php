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

namespace Tests\PHPUnit\Modules\ClientMapper\Models;

use Modules\Admin\Models\Account;
use Modules\Admin\Models\AccountMapper;
use Modules\Profile\Models\Profile;
use Modules\Profile\Models\ProfileMapper;
use Modules\Media\Models\Media;
use phpOMS\Account\AccountStatus;
use phpOMS\Account\AccountType;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Utils\RnG\Name;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class ProfileMapperTest extends \PHPUnit\Framework\TestCase
{

    public function testCRUD()
    {
        $profile = new Profile();

        $profile->setAccount(AccountMapper::get(1));

        $media = new Media();
        $media->setCreatedBy(1);
        $media->setDescription('desc');
        $media->setPath('Web/Backend/img/default-user.jpg');
        $media->setSize(11);
        $media->setExtension('png');
        $media->setName('Image');

        $profile->setImage($media);
        $profile->setBirthday($date = new \DateTime('now'));

        $id = ProfileMapper::create($profile);
        self::assertGreaterThan(0, $profile->getId());
        self::assertEquals($id, $profile->getId());

        $profileR = ProfileMapper::get($profile->getId());
        self::assertEquals($profile->getBirthday()->format('Y-m-d'), $profileR->getBirthday()->format('Y-m-d'));
        self::assertEquals($profile->getImage()->getName(), $profileR->getImage()->getName());
        self::assertEquals($profile->getAccount()->getName1(), $profileR->getAccount()->getName1());
    }
}
