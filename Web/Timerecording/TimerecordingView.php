<?php
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package   Web\Timerecording
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Web\Timerecording;

use Modules\Organization\Models\Unit;
use Modules\Profile\Models\Profile;
use phpOMS\Uri\UriFactory;
use phpOMS\Views\View;

/**
 * Main view.
 *
 * @package Web\Timerecording
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
class TimerecordingView extends View
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
        if ($this->profile === null || $this->profile->getImage()->getPath() === '') {
            return UriFactory::build('Web/Timerecording/img/user_default_' . \mt_rand(1, 6) . '.png');
        }

        return UriFactory::build($this->profile->getImage()->getPath());
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
