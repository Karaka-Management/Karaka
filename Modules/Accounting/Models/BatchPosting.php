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
namespace Modules\Accounting\Models;

/**
 * BatchPosting class.
 *
 * @category   Module
 * @package    Accounting
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class BatchPosting implements \Countable
{

    /**
     * ID.
     *
     * @var int
     * @since 1.0.0
     */
    private $id = 0;

    /**
     * Creator.
     *
     * @var int
     * @since 1.0.0
     */
    private $creator = 0;

    /**
     * Created.
     *
     * @var \Datetime
     * @since 1.0.0
     */
    private $created = null;

    /**
     * Description.
     *
     * @var string
     * @since 1.0.0
     */
    private $description = '';

    /**
     * Postings.
     *
     * @var \Modules\Accounting\Models\PostingAbstract[]
     * @since 1.0.0
     */
    private $postings = [];

    /**
     * Constructor.
     *
     * @since  1.0.0
     */
    public function __construct()
    {
        $this->created = new \DateTime('now');
    }

    /**
     * Get id.
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
     * Get description.
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
     * Set description.
     *
     * @param string $desc Description
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setDescription(string $desc)
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
    public function getCreatedAt() : \DateTime
    {
        return $this->created;
    }

    /**
     * Get creator.
     *
     * @return int
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
     * @param int $creator Creator ID
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
     * Get posting.
     *
     * @param int $id Posting ID
     *
     * @return \Modules\Accounting\Models\PostingAbstract
     *
     * @since  1.0.0
     */
    public function getPosting($id)
    {
        return $this->postings[$id];
    }

    /**
     * Remove posting.
     *
     * @param int $id Posting ID
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function removePosting($id)
    {
        unset($this->postings[$id]);
    }

    /**
     * Add posting.
     *
     * @param \Modules\Accounting\Models\PostingAbstract $posting Posting
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function addPosting($posting)
    {
        $this->postings[] = $posting;
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->postings);
    }

}
