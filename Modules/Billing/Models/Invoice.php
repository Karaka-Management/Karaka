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
namespace Modules\Billing\Models;

/**
 * Invoice class.
 *
 * @category   Tasks
 * @package    Modules
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Invoice implements \JsonSerializable
{
    private $id = 0;

    /**
     * Number ID.
     *
     * @var string
     * @since 1.0.0
     */
    private $number = '';

    /**
     * Invoice type.
     *
     * @var int
     * @since 1.0.0
     */
    private $type = InvoiceType::Bill;

    /**
     * Invoice status.
     *
     * @var int
     * @since 1.0.0
     */
    private $status = InvoiceStatus::DONE;

    /**
     * Invoice created at.
     *
     * @var \DateTime
     * @since 1.0.0
     */
    private $createdAt = null;

    /**
     * Invoice send at.
     *
     * @var \DateTime
     * @since 1.0.0
     */
    private $send = null;

    private $createdBy = 0;

    private $client = 0;

    private $shipTo = '';

    private $shipFAO = '';

    private $shipAddress = '';

    private $shipCity = '';

    private $shipZip = '';

    private $shipCountry = '';

    private $billTo = '';

    private $billFAO = '';

    private $billAddress = '';

    private $billCity = '';

    private $billZip = '';

    private $billCountry = '';
    
    /**
     * Person refering for this order.
     *
     * @var int
     * @since 1.0.0
     */
    private $referer = 0;

    private $refererName = 0;

    private $taxId = '';

    private $insurance = null;

    private $freight = null;

    private $net = null;

    private $gross = null;

    private $currency = ISO4217CharEnum::_EUR;
    
    private $info = '';

    private $payment = 0;

    private $paymentText = '';

    private $terms = 0;

    private $termsText = '';

    private $shipping = 0;

    private $shippingText = '';

    private $vouchers = [];

    private $trackings = [];

    private $elements = [];
    /**
     * Reference to other invoice (delivery note/credit note etc).
     *
     * @var \DateTime
     * @since 1.0.0
     */
    private $reference = 0;

    public function __construct()
    {
        $insurance = new Money();
        $freight = new Money();
        $net = new Money();
        $gross = new Money();

        $this->createdAt = new \DateTime();
        $this->send = new \DateTime();
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function getNumber() : string
    {
        return $this->number;
    }

    public function setNumber(string $number) /* : void */
    {
        $this->number = $number;
    }

    public function getType() : int
    {
        return $this->type;
    }

    public function setType(int $type) /* : void */
    {
        $this->type = $type;
    }

    public function getStatus() : int
    {
        return $this->status;
    }

    public function setSatus(int $status) /* : void */
    {
        $this->status = $status;
    }

    public function getCreatedAt() : \DateTime
    {
        return $this->createdAt;
    }

    public function setSend(\DateTime $send) /* : void */
    {
        $this->send = $send;
    }

    public function getSend() : \DateTime
    {
        return $this->send;
    }

    public function getCreatedBy() : int
    {
        return $this->createdBy;
    }

    public function setCreatedBy(int $creator) /* : void */
    {
        $this->createdBy = $creator;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function setClient($client) /* : void */
    {
        $this->client = $client;
    }

    public function setShipTo(string $ship) /* : void */
    {
        $this->shipTo = $ship;
    }

    public function getShipTo() : string
    {
        return $this->shipTo;
    }

    public function setShipFAO(string $ship) /* : void */
    {
        $this->shipFAO = $ship;
    }

    public function getShipFAO() : string
    {
        return $this->shipFAO;
    }

    public function setShipAddress(string $ship) /* : void */
    {
        $this->shipAddress = $ship;
    }

    public function getShipAddress() : string
    {
        return $this->shipAddress;
    }

    public function setShipCity(string $ship) /* : void */
    {
        $this->shipCity = $ship;
    }

    public function getShipCity() : string
    {
        return $this->shipCity;
    }

    public function setShipZip($ship) /* : void */
    {
        $this->shipZip = $ship;
    }

    public function getShipZip() : string
    {
        return $this->shipZip;
    }

    public function setShipCountry(string $ship) /* : void */
    {
        $this->shipCountry = $ship;
    }

    public function getShipCountry() : string
    {
        return $this->shipCountry;
    }

    public function setBillTo(string $bill) /* : void */
    {
        $this->billTo = $bill;
    }

    public function getBillTo() : string
    {
        return $this->billTo;
    }

    public function setBillFAO(string $bill) /* : void */
    {
        $this->billFAO = $bill;
    }

    public function getBillFAO() : string
    {
        return $this->billFAO;
    }

    public function setBillAddress(string $bill) /* : void */
    {
        $this->billAddress = $bill;
    }

    public function getBillAddress() : string
    {
        return $this->billAddress;
    }

    public function setBillCity(string $bill) /* : void */
    {
        $this->billCity = $bill;
    }

    public function getBillCity() : string
    {
        return $this->billCity;
    }

    public function setBillZip($bill) /* : void */
    {
        $this->billZip = $bill;
    }

    public function getBillZip() : string
    {
        return $this->billZip;
    }

    public function setBillCountry(string $bill) /* : void */
    {
        $this->billCountry = $bill;
    }

    public function getBillCountry() : string
    {
        return $this->billCountry;
    }

    public function setReferer(int $referer) /* : void */
    {
        $this->referer = $referer;
    }

    public function getReferer() : int
    {
        return $this->referer;
    }
    
    public function setRefererName(string $refererName) /* : void */
    {
        $this->refererName = $refererName;
    }

    public function getRefererName() : string
    {
        return $this->refererName;
    }

    public function setTaxId(string $tax) /* : void */
    {
        $this->taxId = $tax;
    }

    public function getTaxId() : string
    {
        return $this->taxId;
    }

    public function setInsurance(Money $insurance) /* : void */
    {
        $this->insurance = $insurance;
    }

    public function getInsurance() : Money
    {
        return $this->insurance;
    }

    public function setFreight(Money $freight) /* : void */
    {
        $this->freight = $freight;
    }

    public function getFreight() : Money
    {
        return $this->freight;
    }

    public function getNet() : Money
    {
        return $this->net;
    }

    public function getGross() : Money
    {
        return $this->gross;
    }

    public function setCurrency(string $currency) /* : void */
    {
        $this->currency = $currency;
    }

    public function getCurrency() : string
    {
        return $this->currency;
    }

    public function setInfo(string $info) /* : void */
    {
        $this->info = $info;
    }

    public function getInfo() : string
    {
        return $this->info;
    }

    public function setPayment(int $payment) /* : void */
    {
        $this->payment = $payment;
    }

    public function getPayment()
    {
        return $this->payment;
    }

    public function setPaymentText(string $payment) /* : void */
    {
        $this->paymentText = $payment;
    }

    public function getPaymentText() : string
    {
        return $this->paymentText;
    }

    public function setTerms(int $terms) /* : void */
    {
        $this->terms = $terms;
    }

    public function getTerms()
    {
        return $this->terms;
    }
    
    public function setTermsText(string $terms) /* : void */
    {
        $this->termsText = $terms;
    }

    public function getTermsText() : string
    {
        return $this->termsText;
    }

    public function setShipping(int $shipping) /* : void */
    {
        $this->shipping = $shipping;
    }

    public function getShipping() 
    {
        return $this->shipping;
    }

    public function setShippingText(string $shipping) /* : void */
    {
        $this->shippingText = $shipping;
    }

    public function getShippingText() : string
    {
        return $this->shippingText;
    }
    
    public function getVouchers() : array
    {
        return $this->vouchers;
    }

    public function addVoucher(string $voucher) /* : void */
    {
        $this->vouchers[] = $voucher;
    }

    public function getTrackings() : array
    {
        return $this->trackings;
    }

    public function addTracking(string $tracking) /* : void */
    {
        $this->trackings[] = $tracking;
    }

    public function getElements() : array
    {
        return $this->elements;
    }

    public function addElement($element) /* : void */
    {
        $this->elements[] = $element;
    }

    public function jsonSerialize()
    {
        
    }
}