<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Model
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Model;

/**
 * Setting model.
 *
 * @package Model
 * @license OMS License 2.2
 * @link    https://jingga.app
 * @since   1.0.0
 */
class Setting implements \JsonSerializable
{
    /**
     * Id
     *
     * @var int
     * @since 1.0.0
     */
    public int $id = 0;

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
     * Pattern
     *
     * @var string
     * @since 1.0.0
     */
    public string $pattern = '';

    /**
     * Unit id
     *
     * @var null|int
     * @since 1.0.0
     */
    public ?int $unit = null;

    /**
     * App id
     *
     * @var null|int
     * @since 1.0.0
     */
    public ?int $app = null;

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
     * Is the data encrypted?
     *
     * @var bool
     * @since 1.0.0
     */
    public bool $isEncrypted = false;

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
     * @param int         $id          Id
     * @param string      $name        Name
     * @param string      $content     Content
     * @param string      $pattern     Pattern
     * @param null|int    $unit        Unit
     * @param null|int    $app         App
     * @param null|string $module      Module
     * @param null|int    $group       Group
     * @param null|int    $account     Account
     * @param bool        $isEncrypted Is the data encrypted?
     *
     * @return self
     *
     * @since 1.0.0
     */
    public function with(
        int $id = 0,
        string $name = '',
        string $content = '',
        string $pattern = '',
        ?int $unit = null,
        ?int $app = null,
        ?string $module = null,
        ?int $group = null,
        ?int $account = null,
        bool $isEncrypted = false,
    ) : self {
        $this->id          = $id;
        $this->name        = $name;
        $this->content     = $content;
        $this->pattern     = $pattern;
        $this->unit        = $unit;
        $this->app         = $app;
        $this->module      = $module;
        $this->group       = $group;
        $this->account     = $account;
        $this->isEncrypted = $isEncrypted;

        return $this;
    }

    /**
     * Constructor.
     *
     * @param int         $id          Id
     * @param string      $name        Name
     * @param string      $content     Content
     * @param string      $pattern     Pattern
     * @param null|int    $unit        Unit
     * @param null|int    $app         App
     * @param null|string $module      Module
     * @param null|int    $group       Group
     * @param null|int    $account     Account
     * @param bool        $isEncrypted Is the data encrypted?
     *
     * @return self
     *
     * @since 1.0.0
     */
    public function __construct(
        int $id = 0,
        string $name = '',
        string $content = '',
        string $pattern = '',
        ?int $unit = null,
        ?int $app = null,
        ?string $module = null,
        ?int $group = null,
        ?int $account = null,
        bool $isEncrypted = false
    ) {
        $this->id          = $id;
        $this->name        = $name;
        $this->content     = $content;
        $this->pattern     = $pattern;
        $this->unit        = $unit;
        $this->app         = $app;
        $this->module      = $module;
        $this->group       = $group;
        $this->account     = $account;
        $this->isEncrypted = $isEncrypted;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray() : array
    {
        return [
           'id'          => $this->id,
           'name'        => $this->name,
           'content'     => $this->content,
           'pattern'     => $this->pattern,
           'unit'        => $this->unit,
           'app'         => $this->app,
           'module'      => $this->module,
           'group'       => $this->group,
           'account'     => $this->account,
           'isEncrypted' => $this->isEncrypted,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize() : mixed
    {
        return $this->toArray();
    }
}
