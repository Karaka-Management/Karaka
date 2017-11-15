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
use phpOMS\Localization\Localization;
use phpOMS\Localization\NullLocalization;
use phpOMS\Validation\Network\Email;

/**
 * Account class.
 * 
 * The account class is the base model for accounts. This model contains the most common account 
 * information. This model is not comparable to a profile which contains much more information. 
 *
 * @category   Framework
 * @package    phpOMS\Account
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Account implements ArrayableInterface, \JsonSerializable
{

    /**
     * Id.
     *
     * @var int
     * @since 1.0.0
     */
    protected $id = 0;

    /**
     * Names.
     *
     * @var string
     * @since 1.0.0
     */
    protected $name1 = '';

    /**
     * Names.
     *
     * @var string
     * @since 1.0.0
     */
    protected $name2 = '';

    /**
     * Names.
     *
     * @var string
     * @since 1.0.0
     */
    protected $name3 = '';

    /**
     * Email.
     *
     * @var string
     * @since 1.0.0
     */
    protected $email = '';

    /**
     * Ip.
     *
     * Used in order to make sure ips don't change
     *
     * @var string
     * @since 1.0.0
     */
    protected $origin = '';

    /**
     * Login.
     *
     * @var string
     * @since 1.0.0
     */
    protected $login = '';

    /**
     * Last activity.
     *
     * @var \DateTime
     * @since 1.0.0
     */
    protected $lastActive = null;

    /**
     * Last activity.
     *
     * @var \DateTime
     * @since 1.0.0
     */
    protected $createdAt = null;

    /**
     * Permissions.
     *
     * @var PermissionAbstract[]
     * @since 1.0.0
     */
    protected $permissions = [];

    /**
     * Groups.
     *
     * @var int[]
     * @since 1.0.0
     */
    protected $groups = [];

    /**
     * Password.
     *
     * @var string
     * @since 1.0.0
     */
    protected $password = '';

    /**
     * Account type.
     *
     * @var int
     * @since 1.0.0
     */
    protected $type = AccountType::USER;

    /**
     * Account status.
     *
     * @var int
     * @since 1.0.0
     */
    protected $status = AccountStatus::INACTIVE;

    /**
     * Localization.
     *
     * @var Localization
     * @since 1.0.0
     */
    protected $l11n = null;

    /**
     * Constructor.
     * 
     * The constructor automatically sets the created date as well as the last activity to now.
     *
     * @param int $id Account id
     *
     * @since  1.0.0
     */
    public function __construct(int $id = 0)
    {
        $this->createdAt = new \DateTime('now');
        $this->lastActive = new \DateTime('now');
        $this->id        = $id;
        $this->l11n      = new NullLocalization();
    }

    /**
     * Get account id.
     *
     * @return int Account id
     *
     * @since  1.0.0
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * Get localization.
     * 
     * Every account can have a different localization which can be accessed here.
     *
     * @return Localization
     *
     * @since  1.0.0
     */
    public function getL11n() : Localization
    {
        return $this->l11n;
    }

    /**
     * Get groups.
     * 
     * Every account can belong to multiple groups. 
     * These groups usually are used for permissions and categorize accounts.
     *
     * @return array Returns array of all groups
     *
     * @since  1.0.0
     */
    public function getGroups() : array
    {
        return $this->groups;
    }

    /**
     * Add group.
     * 
     * @param mixed $group Group to add
     * 
     * @return void
     *
     * @since  1.0.0
     */
    public function addGroup($group) /* : void */
    {
        $this->groups[] = $group;
    }

    /**
     * Set localization.
     *
     * @param Localization $l11n Localization
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setL11n(Localization $l11n) /* : void */
    {
        $this->l11n = $l11n;
    }

    /**
     * Set permissions.
     * 
     * The method accepts an array of permissions. All existing permissions are replaced.
     *
     * @param PermissionAbstract[] $permissions
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setPermissions(array $permissions) /* : void */
    {
        $this->permissions = $permissions;
    }

    /**
     * Add permissions.
     * 
     * Adds permissions to the account
     *
     * @param PermissionAbstract[] $permissions Array of permissions to add to the account
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function addPermissions(array $permissions) /* : void */
    {
        $this->permissions = array_merge($this->permissions, $permissions);
    }

    /**
     * Add permission.
     * 
     * Adds a single permission to the account
     *
     * @param PermissionAbstract $permission Permission to add to the account
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function addPermission(PermissionAbstract $permission) /* : void */
    {
        $this->permissions[] = $permission;
    }

    /**
     * Get permissions.
     * 
     * @return array
     *
     * @since  1.0.0
     */
    public function getPermissions() : array
    {
        return $this->permissions;
    }

    /**
     * Has permissions.
     *
     * Checks if the account has a permission defined
     * 
     * @param int $permission Permission to check
     * @param int $unit Unit Unit to check (null if all are acceptable)
     * @param string $app App App to check  (null if all are acceptable)
     * @param int $module Module Module to check  (null if all are acceptable)
     * @param int $type Type (e.g. customer) (null if all are acceptable)
     * @param int $element (e.g. customer id) (null if all are acceptable)
     * @param int $component (e.g. address) (null if all are acceptable)
     *
     * @return bool Returns true if the account has the permission, false otherwise
     *
     * @since  1.0.0
     */
    public function hasPermission(int $permission, int $unit = null, string $app = null, int $module = null, int $type = null, $element = null, $component = null) : bool
    {
        $app = isset($app) ? strtolower($app) : $app;

        foreach ($this->permissions as $p) {
            if (($p->getUnit() === $unit || $p->getUnit() === null || !isset($unit))
                && ($p->getApp() === $app || $p->getApp() === null || !isset($app)) 
                && ($p->getModule() === $module || $p->getModule() === null || !isset($module)) 
                && ($p->getType() === $type || $p->getType() === null || !isset($type)) 
                && ($p->getElement() === $element || $p->getElement() === null || !isset($element)) 
                && ($p->getComponent() === $component || $p->getComponent() === null || !isset($component)) 
                && ($p->getPermission() | $permission) === $p->getPermission()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get name.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getName() : string
    {
        return $this->login;
    }

    /**
     * Get name1.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getName1() : string
    {
        return $this->name1;
    }

    /**
     * Set name1.
     *
     * @param string $name Name
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setName1(string $name) /* : void */
    {
        $this->name1 = $name;
    }

    /**
     * Get name2.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getName2() : string
    {
        return $this->name2;
    }

    /**
     * Set name2.
     *
     * @param string $name Name
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setName2(string $name) /* : void */
    {
        $this->name2 = $name;
    }

    /**
     * Get name3.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getName3() : string
    {
        return $this->name3;
    }

    /**
     * Set name3.
     *
     * @param string $name Name
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setName3(string $name) /* : void */
    {
        $this->name3 = $name;
    }

    /**
     * Get email.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getEmail() : string
    {
        return $this->email;
    }

    /**
     * Set email.
     *
     * @param string $email Email
     *
     * @return void
     * 
     * @throws \InvalidArgumentException Exception is thrown if the provided string is not a valid email
     *
     * @since  1.0.0
     */
    public function setEmail(string $email) /* : void */
    {
        if (!Email::isValid($email)) {
            throw new \InvalidArgumentException();
        }

        $this->email = mb_strtolower($email);
    }

    /**
     * Get status.
     *
     * AccountStatus
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function getStatus() : int
    {
        return $this->status;
    }

    /**
     * Get status.
     *
     * @param int $status Status
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setStatus(int $status) /* : void */
    {
        if (!AccountStatus::isValidValue($status)) {
            throw new \InvalidArgumentException();
        }

        $this->status = $status;
    }

    /**
     * Get type.
     *
     * AccountType
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function getType() : int
    {
        return $this->type;
    }

    /**
     * Get type.
     *
     * @param int $type Type
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setType(int $type) /* : void */
    {
        if (!AccountType::isValidValue($type)) {
            throw new \InvalidArgumentException();
        }

        $this->type = $type;
    }

    /**
     * Get last activity.
     *
     * @return \DateTime
     *
     * @since  1.0.0
     */
    public function getLastActive() : \DateTime
    {
        return $this->lastActive ?? $this->getCreatedAt();
    }

    /**
     * Get created at.
     *
     * @return \DateTime
     *
     * @since  1.0.0
     */
    public function getCreatedAt() : \DateTime
    {
        return $this->createdAt ?? new \DateTime('NOW');
    }

    /**
     * Generate password.
     *
     * @param string $password Password
     *
     * @return void
     * 
     * @throws \Exception
     *
     * @since  1.0.0
     */
    public function generatePassword(string $password) /* : void */
    {
        $this->password = \password_hash($password, \PASSWORD_DEFAULT);

        if ($this->password === false) {
            throw new \Exception();
        }
    }

    /**
     * Set name.
     *
     * @param string $name Name
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setName(string $name) /* : void */
    {
        $this->login = $name;
    }

    /**
     * Update last activity.
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function updateLastActive() /* : void */
    {
        $this->lastActive = new \DateTime('NOW');
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
            'name'        => [
                $this->name1,
                $this->name2,
                $this->name3,
            ],
            'email'       => $this->email,
            'login'       => $this->login,
            'groups'      => $this->groups,
            'permissions' => $this->permissions,
            'type'        => $this->type,
            'status'      => $this->status,
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
