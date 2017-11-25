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
 * @link       http://website.orange-management.de
 */ /* TODO: maybe make this a framework object? and let warehousing, sales, purchase extend this */
namespace Modules\Warehousing\Models;

/**
 * Article class.
 *
 * @category   Warehousing
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Article 
{

    /**
     * Article ID.
     *
     * @var int
     * @since 1.0.0
     */
    private $id = null;

    /**
     * Name.
     *
     * @var string
     * @since 1.0.0
     */
    private $name = '';

    /**
     * Description.
     *
     * @var string
     * @since 1.0.0
     */
    private $description = '';

    /**
     * Matchcode.
     *
     * @var string
     * @since 1.0.0
     */
    private $matchcode = '';

    /**
     * Sector.
     *
     * @var string
     * @since 1.0.0
     */
    private $sector = null;

    /**
     * Group.
     *
     * @var string
     * @since 1.0.0
     */
    private $group = null;

    /**
     * Suppliers.
     *
     * supplier price leadtime
     *
     * @var string
     * @since 1.0.0
     */
    private $suppliers = null;

    /**
     * Localization strings.
     *
     * [en] Name - Description
     *
     * @var array
     * @since 1.0.0
     */
    private $invoice_i18n = [];

    /**
     * Prizes.
     *
     * [id] name country state prize discount% discountA bonus-in-kind groupA groupB amount event
     *
     * @var array
     * @since 1.0.0
     */
    private $prizes = [];

    /**
     * Active supplier.
     *
     * @var string
     * @since 1.0.0
     */
    private $pprice = null;

    /**
     * Created.
     *
     * @var \Datetime
     * @since 1.0.0
     */
    private $created = null;

    /**
     * Creator.
     *
     * @var \phpOMS\Models\User
     * @since 1.0.0
     */
    private $creator = null;

    /**
     * Article.
     *
     * @var \Modules\Warehousing\Models\Article[]
     * @since 1.0.0
     */
    private static $instances = [];

    /**
     * Constructor.
     *
     * @param int $id Article ID
     *
     * @since  1.0.0
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * {@inheritdoc}
     */
    public function init($id)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function __clone()
    {
    }

    /**
     * Initializing object.
     *
     * @param int $id Article ID
     *
     * @return \Modules\Warehousing\Models\Article
     *
     * @since  1.0.0
     */
    public function getInstance($id)
    {
        if (!isset(self::$instances[$id])) {
            self::$instances[$id] = new self($id);
        }

        return self::$instances[$id];
    }

    /**
     * Get ID.
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get name.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name.
     *
     * @param string $name Name of the article
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get matchcode.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getMatchcode()
    {
        return $this->matchcode;
    }

    /**
     * Set matchcode.
     *
     * @param string $matchcode Matchcode of the article
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setMatchcode($matchcode)
    {
        $this->matchcode = $matchcode;
    }

    /**
     * Get description.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set description.
     *
     * @param string $desc Description of the article
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setDescription($desc)
    {
        $this->description = $desc;
    }

    /**
     * Get created.
     *
     * @return \Datetime
     *
     * @since  1.0.0
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set created.
     *
     * @param \Datetime $created Date of when the article got created
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * Get creator.
     *
     * @return \phpOMS\Models\User
     *
     * @since  1.0.0
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * Set creator.
     *
     * @param \phpOMS\Models\User $creator Creator ID
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;
    }

    /**
     * Add price to pricelist.
     *
     * @param array $price Price
     * @param bool $db    Update DB and cache?
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function addPrice($price, $db = true)
    {
        $id                = 0; /* insert and get id */
        $this->prices[$id] = $price;
    }

    /**
     * Remove price from pricelist.
     *
     * @param int  $id Price ID
     * @param bool $db Update DB and cache?
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function removePrice($id, $db = true)
    {
        if (isset($this->prices[$id])) {
            unset($this->prices[$id]);
        }
    }

    /**
     * Add price to pricelist.
     *
     * @param int  $id    Price ID
     * @param array $price Price
     * @param bool $db    Update DB and cache?
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function editPrice($id, $price, $db = true)
    {
        if (isset($this->prices[$id])) {
            $this->prices[$id] = $price;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function delete()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function create()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function update()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($data)
    {
    }

}
