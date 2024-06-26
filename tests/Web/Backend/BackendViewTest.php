<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
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
#[\PHPUnit\Framework\Attributes\CoversClass(\Web\Backend\BackendView::class)]
class BackendViewTest extends \PHPUnit\Framework\TestCase
{
    #[\PHPUnit\Framework\Attributes\Group('framework')]
    public function testDefault() : void
    {
        $view = new BackendView();

        self::assertStringContainsString('', $view->getProfileImage());
    }

    #[\PHPUnit\Framework\Attributes\Group('framework')]
    public function testProfileImageUrl() : void
    {
        $view = new BackendView();

        $media = new Media();
        $media->setPath('/test/path/image.jpeg');

        $profile        = new Profile();
        $profile->image = $media;

        $view->profile = $profile;
        self::assertEquals('test/path/image.jpeg', $view->getProfileImage());
    }
}
