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
namespace Modules\Surveys;

use phpOMS\Pattern\Multition;

/**
 * Section class.
 *
 * @category   Surveys
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Section implements Multition
{

    /**
     * ID.
     *
     * @var int
     * @since 1.0.0
     */
    private $id = '';

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

    private static $instances = [];

    public function __construct($id)
    {
    }

    public function getInstance($id)
    {
        if (!isset(self::$instances[$id])) {
            self::$instances[$id] = new self($id);
        }

        return self::$instances[$id];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($desc)
    {
        $this->description = $desc;
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

    /**
     * Init object by ID.
     *
     * This usually happens from DB or cache
     *
     * @param int $id Object ID
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function init($id)
    {
        // TODO: Implement init() method.
    }

    /**
     * Overwriting clone in order to maintain singleton pattern.
     *
     * @since  1.0.0
     */
    public function __clone()
    {
        // TODO: Implement __clone() method.
    }
}
