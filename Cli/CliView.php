<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Cli
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Cli;

use Modules\Organization\Models\Unit;
use Modules\Profile\Models\NullProfile;
use Modules\Profile\Models\Profile;
use phpOMS\Localization\L11nManager;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Views\View;

/**
 * List view.
 *
 * @package Cli
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
class CliView extends View
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
    public Profile $profile;

    /**
     * Organizations.
     *
     * @var Unit[]
     * @since 1.0.0
     */
    public array $organizations = [];

    /**
     * Constructor
     *
     * @param L11nManager      $l11n     Localization manager
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Request
     *
     * @since 1.0.0
     */
    public function __construct(?L11nManager $l11n = null, ?RequestAbstract $request = null, ?ResponseAbstract $response = null)
    {
        parent::__construct($l11n, $request, $response);

        $this->profile = new NullProfile();
    }
}
