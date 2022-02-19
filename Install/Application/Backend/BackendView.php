<?php
/**
 * Karaka
 *
 * PHP Version 8.0
 *
 * @package   Web\Backend
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
 */
declare(strict_types=1);

namespace Web\Backend;

use Modules\Media\Models\Media;
use Modules\Media\Models\NullMedia;
use Modules\Organization\Models\Unit;
use Modules\Profile\Models\NullProfile;
use Modules\Profile\Models\Profile;
use phpOMS\Localization\L11nManager;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Uri\UriFactory;
use phpOMS\Views\View;

/**
 * List view.
 *
 * @package Web\Backend
 * @license OMS License 1.0
 * @link    https://karaka.app
 * @since   1.0.0
 */
class BackendView extends View
{
    /**
     * Navigation view
     *
     * @var View
     * @since 1.0.0
     */
    protected ?View $nav = null;

    /**
     * User profile.
     *
     * @var Profile
     * @since 1.0.0
     */
    protected Profile $profile;

    /**
     * User profile image.
     *
     * @var Media
     * @since 1.0.0
     */
    public Media $defaultProfileImage;

    /**
     * Organizations.
     *
     * @var Unit[]
     * @since 1.0.0
     */
    protected array $organizations = [];

    /**
     * Constructor
     *
     * @param L11nManager      $l11n     Localization manager
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Request
     *
     * @since 1.0.0
     */
    public function __construct(L11nManager $l11n = null, RequestAbstract $request = null, ResponseAbstract $response = null)
    {
        parent::__construct($l11n, $request, $response);

        $this->profile             = new NullProfile();
        $this->defaultProfileImage = new NullMedia();
    }

    /**
     * Set navigation view.
     *
     * @param View $nav Navigation view
     *
     * @return void
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function setNavigation(View $nav) : void
    {
        $this->nav = $nav;
    }

    /**
     * Set user profile.
     *
     * @param Profile $profile user account
     *
     * @return void
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function setProfile(Profile $profile) : void
    {
        $this->profile = $profile;
    }

    /**
     * Get profile image
     *
     * @return string Profile image link
     *
     * @since 1.0.0
     */
    public function getProfileImage() : string
    {
        if (($this->profile instanceof NullProfile) || $this->profile->image->getPath() === '') {
            return UriFactory::build('{/prefix}' . $this->defaultProfileImage->getPath());
        }

        return UriFactory::build('{/prefix}' . $this->profile->image->getPath());
    }

    /**
     * Set organizations
     *
     * @param Unit[] $organizations Organizations
     *
     * @return void
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function setOrganizations(array $organizations) : void
    {
        $this->organizations = $organizations;
    }
}
