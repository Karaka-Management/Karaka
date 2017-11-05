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
namespace Modules\Warehousing\Models;

use phpOMS\Pattern\Multition;

/**
 * Warehouse class.
 *
 * @category   Warehousing
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Shipping implements Multition
{

    /**
     * ID.
     *
     * @var int
     * @since 1.0.0
     */
    private $id = 0;

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
    private $to = null;

    /**
     * Warehouse.
     *
     * @var int
     * @since 1.0.0
     */
    private $warehouse = '';

    /**
     * Date of arrival.
     *
     * @var \Datetime
     * @since 1.0.0
     */
    private $delivered = null;

    /**
     * Person who sent the delivery.
     *
     * @var int
     * @since 1.0.0
     */
    private $sender = null;

    /**
     * Warehouse.
     *
     * @var \Modules\Warehousing\Models\ArrivalStatus
     * @since 1.0.0
     */
    private $status = null;

    /**
     * Shipping.
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
     * Initializing object.
     *
     * @param int $id Article ID
     *
     * @return \Modules\Warehousing\Models\Article
     *
     * @since  1.0.0
     */
    public static function getInstance($id)
    {
        if (!isset(self::$instances[$id])) {
            self::$instances[$id] = new self($id);
        }

        return self::$instances[$id];
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
     * @param int $order Order ID
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
     * Get delivered.
     *
     * @return \Datetime
     *
     * @since  1.0.0
     */
    public function getDelivered()
    {
        return $this->delivered;
    }

    /**
     * Set delivered.
     *
     * @param \Datetime $delivered Date of delivery
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setDelivered($delivered)
    {
        $this->delivered = $delivered;
    }

    /**
     * Get To.
     *
     * @return \phpOMS\Stdlib\Base\Address
     *
     * @since  1.0.0
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Set To.
     *
     * @param \phpOMS\Stdlib\Base\Address $to Receiver
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setTo($to)
    {
        $this->to = $to;
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
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Set sender.
     *
     * @param int $sender Person who accepted the consignment
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
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
