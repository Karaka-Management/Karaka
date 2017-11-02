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
namespace Modules\Reporter\Models;

/**
 * Report model.
 *
 * @category   Framework
 * @package    phpOMS\Auth
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Report
{

    /**
     * Report Id.
     *
     * @var int
     * @since 1.0.0
     */
    private $id = 0;

    /**
     * Report status.
     *
     * @var int
     * @since 1.0.0
     */
    private $status = ReporterStatus::INACTIVE;

    /**
     * Report title.
     *
     * @var string
     * @since 1.0.0
     */
    private $title = '';

    /**
     * Report description.
     *
     * @var string
     * @since 1.0.0
     */
    private $description = '';

    /**
     * Report created at.
     *
     * @var \DateTime
     * @since 1.0.0
     */
    protected $createdAt = null;

    /**
     * Report created by.
     *
     * @var int
     * @since 1.0.0
     */
    private $createdBy = 0;

    /**
     * Report template.
     *
     * @var int
     * @since 1.0.0
     */
    private $template = 0;

    /**
     * Report source.
     *
     * @var int
     * @since 1.0.0
     */
    private $source = 0;

    /**
     * Permissions.
     *
     * @var array
     * @since 1.0.0
     */
    private $permissions = [
        'r' => ['groups' => [],
                'users'  => [],],
        'w' => ['groups' => [],
                'users'  => [],],
        'p' => ['groups' => [],
                'users'  => [],],
        'd' => ['groups' => [],
                'users'  => [],],
    ];

    /**
     * Constructor.
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
     * @return int
     *
     * @since  1.0.0
     */
    public function getStatus() : int
    {
        return $this->status;
    }

    /**
     * @param int $status Report status
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
     * @return string
     *
     * @since  1.0.0
     */
    public function getTitle() : string
    {
        return $this->title;
    }

    /**
     * @param string $title Title
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
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
     * @param string $description Description
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
     * @return \DateTime
     *
     * @since  1.0.0
     */
    public function getCreatedAt() : \DateTime
    {
        return $this->createdAt ?? new \DateTime('now');
    }

    /**
     * @param \DateTime $created Created at
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setCreatedAt(\DateTime $created)
    {
        $this->createdAt = $created;
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
     * @param mixed $creator Created by
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setCreatedBy($creator)
    {
        $this->createdBy = $creator;
    }

    /**
     * @return mixed
     *
     * @since  1.0.0
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param mixed $template Report template
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }

    /**
     * @param mixed $source Report source
     *
     * @return void
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
}
