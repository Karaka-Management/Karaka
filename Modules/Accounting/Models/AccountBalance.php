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
 * Account balance class.
 *
 * @category   Modules
 * @package    Modules\Accounting\Models
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
abstract class AccountBalance
{

    /**
     * Id.
     *
     * @var int
     * @since 1.0.0
     */
    private $id = null;

    /**
     * Time range start.
     *
     * @var \DateTime
     * @since 1.0.0
     */
    private $start = null;

    /**
     * Time range end.
     *
     * @var \DateTime
     * @since 1.0.0
     */
    private $end = null;

    /**
     * Time range type.
     *
     * @var \Modules\Accounting\Models\TimeRangeType
     * @since 1.0.0
     */
    private $rangetype = null;

    /**
     * Account.
     *
     * @var \Modules\Accounting\Models\AccountInterface
     * @since 1.0.0
     */
    private $account = null;

    /**
     * Balance.
     *
     * @var float
     * @since 1.0.0
     */
    private $balance = null;

    /**
     * Constructor.
     *
     * @param int $id Account id
     *
     * @since  1.0.0
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return \DateTime
     *
     * @since  1.0.0
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @param \DateTime $start
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setStart($start)
    {
        $this->start = $start;
    }

    /**
     * @return \DateTime
     *
     * @since  1.0.0
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @param \DateTime $end
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setEnd($end)
    {
        $this->end = $end;
    }

    /**
     * @return TimeRangeType
     *
     * @since  1.0.0
     */
    public function getRangetype()
    {
        return $this->rangetype;
    }

    /**
     * @param TimeRangeType $rangetype
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setRangetype($rangetype)
    {
        $this->rangetype = $rangetype;
    }

    /**
     * @return AccountInterface
     *
     * @since  1.0.0
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * @param AccountInterface $account
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setAccount($account)
    {
        $this->account = $account;
    }

    /**
     * @return float
     *
     * @since  1.0.0
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @param float $balance
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;
    }
}
