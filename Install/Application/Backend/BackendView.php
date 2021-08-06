<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   Web\Backend
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Web\Backend;

use Modules\Organization\Models\Unit;
use Modules\Profile\Models\Profile;
use Modules\Media\Models\Media;
use phpOMS\Uri\UriFactory;
use phpOMS\Views\View;

/**
 * List view.
 *
 * @package Web\Backend
 * @license OMS License 1.0
 * @link    https://orange-management.org
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
    protected $nav = null;

    /**
     * User profile.
     *
     * @var Profile
     * @since 1.0.0
     */
    protected $profile = null;

    /**
     * User profile image.
     *
     * @var Media
     * @since 1.0.0
     */
    public ?Media $defaultProfileImage = null;

    /**
     * Organizations.
     *
     * @var Unit[]
     * @since 1.0.0
     */
    protected $organizations = null;

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
        if ($this->profile === null || $this->profile->image->getPath() === '') {
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
