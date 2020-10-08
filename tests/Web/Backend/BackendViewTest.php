<?php
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace tests\Web\Backend;

require_once __DIR__ . '/../../../phpOMS/Autoloader.php';

use Modules\Media\Models\Media;
use Modules\Profile\Models\Profile;
use Web\Backend\BackendView;

/**
 * @internal
 */
class BackendViewTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers Web\Backend\BackendView
     * @group framework
     */
    public function testDefault() : void
    {
        $view = new BackendView();

        self::assertStringContainsString('Web/Backend/img/user_default_', $view->getProfileImage());
    }

    /**
     * @covers Web\Backend\BackendView
     * @group framework
     */
    public function testProfileImageUrl() : void
    {
        $view = new BackendView();

        $media = new Media();
        $media->setPath('/test/path/image.jpeg');

        $profile = new Profile();
        $profile->setImage($media);

        $view->setProfile($profile);
        self::assertEquals('test/path/image.jpeg', $view->getProfileImage());
    }
}
