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

use phpOMS\Contract\ArrayableInterface;

/**
 * Account group class.
 *
 * @category   Framework
 * @package    phpOMS\Account
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Group implements ArrayableInterface, \JsonSerializable
{

    /**
     * Account id.
     *
     * @var int
     * @since 1.0.0
     */
    protected $id = 0;

    /**
     * Account name.
     *
     * @var string
     * @since 1.0.0
     */
    protected $name = '';

    /**
     * Account name.
     *
     * @var string
     * @since 1.0.0
     */
    protected $description = '';

    /**
     * Account name.
     *
     * @var int
     * @since 1.0.0
     */
    protected $members = [];

    /**
     * Parents.
     *
     * @var int[]
     * @since 1.0.0
     */
    protected $parents = [];

    /**
     * Group status.
     *
     * @var int
     * @since 1.0.0
     */
    protected $status = GroupStatus::INACTIVE;

    /**
     * Permissions.
     *
     * @var int[]
     * @since 1.0.0
     */
    protected $permissions = [];

    /**
     * Constructor.
     *
     * @since  1.0.0
     */
    public function __construct()
    {
    }

    /**
     * Get group id.
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
     * Get group name.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Set group name.
     *
     * @param string $name Group name
     *
     * @since  1.0.0
     */
    public function setName(string $name) /* : void */
    {
        $this->name = $name;
    }

    /**
     * Get group description.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getDescription() : string
    {
        return $this->description;
    }

    /**
     * Set group description.
     *
     * @param string $description Group description
     *
     * @since  1.0.0
     */
    public function setDescription(string $description) /* : void */
    {
        $this->description = $description;
    }

    /**
     * Get group status.
     *
     * @return int Group status
     *
     * @since  1.0.0
     */
    public function getStatus() : int
    {
        return $this->status;
    }

    /**
     * Set group status.
     *
     * @param int $status Group status
     *
     * @since  1.0.0
     */
    public function setStatus(int $status) /* : void */
    {
        // todo: check valid
        $this->status = $status;
    }

    /**
     * Get string representation.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function __toString()
    {
        return json_encode($this->toArray());
    }

    /**
     * {@inheritdoc}
     */
    public function toArray() : array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'permissions' => $this->permissions,
            'members'     => $this->members,
        ];
    }

    /**
     * Json serialize.
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
