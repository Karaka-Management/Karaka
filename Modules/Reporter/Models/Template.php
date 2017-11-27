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
 */
declare(strict_types = 1);
namespace Modules\Reporter\Models;

/**
 * Template model.
 *
 * @category   Framework
 * @package    phpOMS\Auth
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Template implements \JsonSerializable
{

    /**
     * Template Id.
     *
     * @var int
     * @since 1.0.0
     */
    private $id = 0;

    /**
     * Template status.
     *
     * @var int
     * @since 1.0.0
     */
    private $status = ReporterStatus::INACTIVE;

    /**
     * Template data source.
     *
     * @var int
     * @since 1.0.0
     */
    private $datatype = TemplateDataType::OTHER;

    /**
     * Template doesn't need reports.
     *
     * @var bool
     * @since 1.0.0
     */
    private $isStandalone = false;

    /**
     * Template name.
     *
     * @var string
     * @since 1.0.0
     */
    private $name = '';

    /**
     * Template description.
     *
     * @var string
     * @since 1.0.0
     */
    private $description = '';

    /**
     * Template created at.
     *
     * @var \DateTime
     * @since 1.0.0
     */
    protected $createdAt = null;

    /**
     * Template created by.
     *
     * @var int
     * @since 1.0.0
     */
    private $createdBy = 0;

    /**
     * Template source.
     *
     * @var int
     * @since 1.0.0
     */
    private $source = 0;

    /**
     * Expected files.
     *
     * @var array
     * @since 1.0.0
     */
    private $expected = [];

    /**
     * Constructor
     *
     * @since  1.0.0
     */
    public function __construct()
    {
    }

    /**
     * @return int
     *
     * @since  1.0.0
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @param string $name Template name
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     *
     * @since  1.0.0
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param string $description Template description
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     *
     * @since  1.0.0
     */
    public function getDescription() : string
    {
        return $this->description;
    }

    /**
     * @param int $source Source
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public function setSource($source)
    {
        $this->source = $source;
    }

    /**
     * @return mixed
     *
     * @since  1.0.0
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param mixed $createdBy Creator
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @param \DateTime $createdAt Creation date
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     *
     * @since  1.0.0
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @return \DateTime
     *
     * @since  1.0.0
     */
    public function getCreatedAt() : \DateTime
    {
        return $this->createdAt ?? new \DateTime('now');
    }

    /**
     * @param array $expected Expected files
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setExpected(array $expected)
    {
        $this->expected = $expected;
    }

    /**
     * @return \array
     *
     * @since  1.0.0
     */
    public function getExpected() : array
    {
        return $this->expected;
    }

    /**
     * @param string $expected Expected file
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function addExpected(string $expected)
    {
        $this->expected[] = $expected;
    }

    /**
     * @param int $status Template status (is active?)
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setStatus(int $status)
    {
        $this->status = $status;
    }

    /**
     * @return int
     *
     * @since  1.0.0
     */
    public function getStatus() : int
    {
        return $this->status;
    }

    /**
     * @param int $datatype Template datatype source
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setDatatype(int $datatype)
    {
        $this->datatype = $datatype;
    }

    /**
     * @return int
     *
     * @since  1.0.0
     */
    public function getDatatype() : int
    {
        return $this->datatype;
    }

    /**
     * @param bool $isStandalone Is template standalone
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setStandalone(bool $isStandalone)
    {
        $this->isStandalone = $isStandalone;
    }

    /**
     * @return bool
     *
     * @since  1.0.0
     */
    public function isStandalone() : bool
    {
        return $this->isStandalone;
    }

    public function toArray() : array
    {
        return [
            'id' => $this->id,
            'createdBy' => $this->createdBy,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
            'datatype' => $this->datatype,
            'standalone' => $this->isStandalone,
        ];
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
