<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   Framework
 * @package    phpOMS\Account
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
declare(strict_types = 1);

namespace phpOMS\Account;

/**
 * Permission class.
 * 
 * This permission abstract is the basis for all permissions. Contrary to it's name it is not an
 * abstract class and can be used directly if needed.
 *
 * @category   Framework
 * @package    phpOMS\Account
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class PermissionAbstract
{
    /**
     * Permission id.
     *
     * @var int
     * @since 1.0.0
     */
    protected $id = 0;

    /**
     * Unit id.
     *
     * @var int
     * @since 1.0.0
     */
    protected $unit = null;

    /**
     * App name.
     *
     * @var string
     * @since 1.0.0
     */
    protected $app = null;

    /**
     * Module id.
     *
     * @var int
     * @since 1.0.0
     */
    protected $module = null;

    /**
     * Providing module id.
     *
     * @var int
     * @since 1.0.0
     */
    protected $from = 0;

    /**
     * Type.
     *
     * @var int
     * @since 1.0.0
     */
    protected $type = null;

    /**
     * Element id.
     *
     * @var int
     * @since 1.0.0
     */
    protected $element = null;

    /**
     * Component id.
     *
     * @var int
     * @since 1.0.0
     */
    protected $component = null;

    /**
     * Permission.
     *
     * @var int
     * @since 1.0.0
     */
    protected $permission = PermissionType::NONE;

    /**
     * Get permission id.
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * Get unit id.
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function getUnit() /* : ?int */
    {
        return $this->unit;
    }

    /**
     * Set unit id.
     *
     * @param int $unit Unit
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setUnit(int $unit = null) /* : void */
    {
        $this->unit = $unit;
    }

    /**
     * Get app name.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getApp() /* : ?string */
    {
        return $this->app;
    }

    /**
     * Set app name.
     *
     * @param string $app App name
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setApp(string $app = null) /* : void */
    {
        $this->app = $app;
    }

    /**
     * Get module id.
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function getModule() /* : ?int */
    {
        return $this->module;
    }

    /**
     * Set module id.
     *
     * @param int $module Module
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setModule(int $module = null) /* : void */
    {
        $this->module = $module;
    }

    /**
     * Get providing module id.
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function getFrom() /* : ?int */
    {
        return $this->from;
    }

    /**
     * Set providing module id.
     *
     * @param int $from Providing module
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setFrom(int $from = null) /* : void */
    {
        $this->from = $from;
    }

    /**
     * Get type.
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function getType() /* : ?int */
    {
        return $this->type;
    }

    /**
     * Set type.
     *
     * @param int $type Type
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setType(int $type = null) /* : void */
    {
        $this->type = $type;
    }

    /**
     * Get element id.
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function getElement() /* : ?int */
    {
        return $this->element;
    }

    /**
     * Set element id.
     *
     * @param int $element Element id
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setElement(int $element = null) /* : void */
    {
        $this->element = $element;
    }

    /**
     * Get component id.
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function getComponent() /* : ?int */
    {
        return $this->component;
    }

    /**
     * Set component id.
     *
     * @param int $component Component
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setComponent(int $component = null) /* : void */
    {
        $this->component = $component;
    }

    /**
     * Get permission
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function getPermission() : int
    {
        return $this->permission;
    }

    /**
     * Set permission.
     *
     * @param int $permission Permission
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setPermission(int $permission = 0) /* : void */
    {
        $this->permission = $permission;
    }

    /**
     * Add permission.
     *
     * @param int $permission Permission
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function addPermission(int $permission = 0) /* : void */
    {
        $this->permission |= $permission;
    }

    /**
     * Has permission.
     *
     * @param int $permission Permission
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function hasPermission(int $permission) : bool 
    {
        return ($this->permission | $permission) === $this->permission;
    }
}
