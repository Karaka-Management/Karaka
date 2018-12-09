<?php
/**
 * Orange Management
 *
 * PHP Version 7.2
 *
 * @package    Web\Backend
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
declare(strict_types=1);

namespace Web\Backend;

use Modules\Organization\Models\Unit;
use Modules\Profile\Models\Profile;
use phpOMS\Uri\UriFactory;
use phpOMS\Views\View;

/**
 * List view.
 *
 * @package    Web\Backend
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
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
     * @since  1.0.0
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
     * @since  1.0.0
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
     * @since  1.0.0
     */
    public function getProfileImage() : string
    {
        if ($this->profile === null || $this->profile->getImage()->getPath() === '') {
            return UriFactory::build('/Web/Backend/img/user_default_' . mt_rand(1, 6) . '.png');
        }

        return UriFactory::build('/' . $this->profile->getImage()->getPath());
    }

    /**
     * Set organizations
     *
     * @param Unit[] $organizations Organizations
     *
     * @return void
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function setOrganizations(array $organizations) : void
    {
        $this->organizations = $organizations;
    }
}
