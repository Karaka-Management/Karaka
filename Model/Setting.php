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
    protected int $id = 0;

    public string $name = '';

    public string $content = '';

    public ?string $module = null;

    public ?int $group = null;

    public ?int $account = null;

    public function getId() : int
    {
        return $this->id;
    }

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
