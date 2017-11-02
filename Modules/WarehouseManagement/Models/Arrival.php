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
namespace Modules\Warehousing\Models;

use phpOMS\Pattern\Multition;

/**
 * Warehouse class.
 *
 * @category   Warehousing
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Arrival implements Multition
{

    /**
     * ID.
     *
     * @var int
     * @since 1.0.0
     */
    private $id = '';

    /**
     * Order.
     *
     * @var int
     * @since 1.0.0
     */
    private $order = '';

    /**
     * From.
     *
     * @var \phpOMS\Stdlib\Base\Address
     * @since 1.0.0
     */
    private $from = null;

    /**
     * Warehouse.
     *
     * @var \Modules\Warehousing\Models\Warehouse
     * @since 1.0.0
     */
    private $warehouse = null;

    /**
     * Date of arrival.
     *
     * @var \Datetime
     * @since 1.0.0
     */
    private $date = null;

    /**
     * Person who accepted the delivery.
     *
     * @var int
     * @since 1.0.0
     */
    private $acceptor = null;

    /**
     * Warehouse.
     *
     * @var \Modules\Warehousing\Models\ArrivalStatus
     * @since 1.0.0
     */
    private $status = null;

    /* TODO: count, packaging, product count etc.... for every single position + where do you put it */

    /**
     * Arrival.
     *
     * @var \Modules\Warehousing\Models\Arrival[]
     * @since 1.0.0
     */
    private static $instances = [];

    /**
     * Constructor.
     *
     * @param int $id Arrival ID
     *
     * @since  1.0.0
     */
    private function __construct($id)
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
     * @param int $id Arrival ID
     *
     * @return \Modules\Warehousing\Models\Arrival
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
     * Get date of when the consignment arrived.
     *
     * @return \Datetime Date of arrival
     *
     * @since  1.0.0
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set date of when the consignment arrived.
     *
     * @param \Datetime $date Date of arrival
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * Get order.
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set order.
     *
     * @param int $order Order Id
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * Get From.
     *
     * @return \phpOMS\Stdlib\Base\Address
     *
     * @since  1.0.0
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Set From.
     *
     * @param \phpOMS\Stdlib\Base\Address $from Consignor
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

    /**
     * Get status.
     *
     * @return \Modules\Warehousing\Models\ArrivalStatus
     *
     * @since  1.0.0
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set status.
     *
     * @param  \Modules\Warehousing\Models\ArrivalStatus
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Get warehouse.
     *
     * @return \Modules\Warehousing\Models\Warehouse
     *
     * @since  1.0.0
     */
    public function getWarehouse()
    {
        return $this->warehouse;
    }

    /**
     * Get acceptor.
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function getAcceptor()
    {
        return $this->acceptor;
    }

    /**
     * Set acceptor.
     *
     * @param int $acceptor Person who accepted the consignment
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setAcceptor($acceptor)
    {
        $this->acceptor = $acceptor;
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
