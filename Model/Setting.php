<?php
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package   Model
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Model;

/**
 * Setting model.
 *
 * @package Model
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
class Setting
{
    /**
     * Id
     *
     * @var int
     * @since 1.0.0
     */
    protected int $id = 0;

    /**
     * Name
     *
     * @var string
     * @since 1.0.0
     */
    public string $name = '';

    /**
     * Content
     *
     * @var string
     * @since 1.0.0
     */
    public string $content = '';

    /**
     * Module name
     *
     * @var null|string
     * @since 1.0.0
     */
    public ?string $module = null;

    /**
     * Group
     *
     * @var null|int
     * @since 1.0.0
     */
    public ?int $group = null;

    /**
     * Account
     *
     * @var null|int
     * @since 1.0.0
     */
    public ?int $account = null;

    /**
     * Get id
     *
     * @return int
     *
     * @since 1.0.0
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * Create setting with data
     *
     * @param int      $id      Id
     * @param string   $name    Name
     * @param string   $content Content
     * @param string   $module  Module
     * @param null|int $group   Group
     * @param null|int $account Account
     *
     * @return self
     *
     * @since 1.0.0
     */
    public function with(
        int $id = 0,
        string $name = '',
        string $content = '',
        string $module = null,
        int $group = null,
        int $account = null
    ) : self {
        $this->id      = $id;
        $this->name    = $name;
        $this->content = $content;
        $this->module  = $module;
        $this->group   = $group;
        $this->account = $account;

        return $this;
    }
}
