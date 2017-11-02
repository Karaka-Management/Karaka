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
namespace Modules\Accounting\Models;

use phpOMS\Utils\IO\ExchangeInterface;

/**
 * BatchPosting class.
 *
 * @category   Module
 * @package    Accounting
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class BatchPosting implements ExchangeInterface, \Countable
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
    private $creator = null;

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
    private $description = null;

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
     * Set id.
     *
     * @param int $id Batch ID
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @param string $desc Description
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setDescription($desc)
    {
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
     * Set creator.
     *
     * @param \Datetime $created Created
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

    /**
     * {@inheritdoc}
     */
    public function exportJson($path)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function importJson($path)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function exportCsv($path)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function importCsv($path)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function exportExcel($path)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function importExcel($path)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function exportPdf($path)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function importPdf($path)
    {
    }
}
