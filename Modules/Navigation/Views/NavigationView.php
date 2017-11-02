<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   TBD
 * @package    TBD
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://orange-management.com
 */
declare(strict_types = 1);
namespace Modules\Navigation\Views;

use phpOMS\Views\View;

/**
 * Navigation view.
 *
 * @category   Modules
 * @package    Modules\Navigation
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class NavigationView extends View
{

    /**
     * Navigation Id.
     *
     * This is getting used in order to identify which navigation elements should get rendered.
     * This usually is the parent navigation id
     *
     * @var int
     * @since 1.0.0
     */
    protected $navId = null;

    /**
     * Navigation.
     *
     * @var mixed[]
     * @since 1.0.0
     */
    protected $nav = [];

    /**
     * Language used for the navigation.
     *
     * @var string
     * @since 1.0.0
     */
    protected $language = 'en';

    /**
     * Parent element used for navigation.
     *
     * @var int
     * @since 1.0.0
     */
    protected $parent = 0;

    /**
     * {@inheritdoc}
     */
    public function __construct($app, $request, $response)
    {
        parent::__construct($app, $request, $response);
    }

    /**
     * Get navigation Id.
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function getNavId() : int
    {
        return $this->navId;
    }

    /**
     * Set navigation Id.
     *
     * @param int $navId Navigation id used for display
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setNavId(int $navId)
    {
        $this->navId = $navId;
    }

    /**
     * @return array
     *
     * @since  1.0.0
     */
    public function getNav() : array
    {
        return $this->nav;
    }

    /**
     * @param mixed $nav
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setNav(array $nav)
    {
        $this->nav = $nav;
    }

    /**
     * @return string
     *
     * @since  1.0.0
     */
    public function getLanguage() : string
    {
        return $this->language;
    }

    /**
     * @param string $language
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setLanguage(string $language)
    {
        $this->language = $language;
    }

    /**
     * @return int
     *
     * @since  1.0.0
     */
    public function getParent() : int
    {
        return $this->parent;
    }

    /**
     * @param int $parent
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setParent(int $parent)
    {
        $this->parent = $parent;
    }
}
