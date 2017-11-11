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
class InvoiceElement implements \JsonSerializable
{
    private $id = 0;

    private $order = 0;

    private $item = 0;

    private $itemName = '';

    private $itemDescription = '';
    
    private $quantity = 0;

    private $singlePrice = null;

    private $totalPrice = null;

    private $singleDiscountP = null;

    private $totalDiscountP = null;

    private $singleDiscountR = 0;

    private $totalDiscountR = null;

    private $discountQ = 0;
    
    private $singlePriceNet = null;

    private $totalPriceNet = null;

    private $taxP = null;

    private $taxR = null;

    private $singlePriceGross = null;

    private $totalPriceGross = null;

    private $event = 0;

    private $promotion = 0;

    private $invoice = 0;

    public function __construct()
    {

    }

    public function getId() : int
    {
        return $this->id;
    }

    public function setEvent(int $event) /* : void */
    {
        $this->event = $event;
    }

    public function getEvent()
    {
        return $this->event;
    }

    public function setPromotion(int $promotion) /* : void */
    {
        $this->promotion = $promotion;
    }

    public function getPromotion() 
    {
        return $this->promotion;
    }

    public function setOrder(int $order) /* : void */
    {
        $this->order = $order;
    }

    public function getorder() : int
    {
        return $this->order;
    }

    public function setItem($item) /* : void */
    {
        $this->item = $item;
    }

    public function setItemName(string $name) /* : void */
    {
        $this->itemName = $name;
    }

    public function getItemName() : string
    {
        return $this->itemName;
    }

    public function setItemDescription(string $description) /* : void */
    {
        $this->itemDescription = $description;
    }

    public function getItemDescripion() : string
    {
        return $this->itemDescription;
    }

    public function setQuantity(int $quantity) /* : void */
    {
        $this->quantity = $quantity;
    }

    public function getQuantity() : int
    {
        return $this->quantity;
    }

    public function setSinglePrice(Money $price) /* : void */
    {
        $this->singlePrice = $price;
    }

    public function getSinglePrice() : Money
    {
        return $this->singlePrice;
    }

    public function setTotalPrice(Money $price) /* : void */
    {
        $this->totalPrice = $price;
    }

    public function getTotalPrice() : Money
    {
        return $this->totalPrice;
    }

    public function setDiscountPrice(Money $discount) /* : void */
    {
        $this->singleDiscountP = $discount;
    }

    public function getDiscountPrice() : Money
    {
        return $this->singleDiscountP;
    }

    public function setTotalDiscountPrice(Money $discount) /* : void */
    {
        $this->totalDiscountP = $discount;
    }

    public function getTotalDiscountPrice() : Money
    {
        return $this->totalDiscountP;
    }

    public function setDiscountPercentage(float $discount) /* : void */
    {
        $this->singleDiscountR = $discount;
    }

    public function getDiscountPercentage() : float
    {
        return $this->singleDiscountR;
    }

    public function setTotalDiscountPercentage(float $discount) /* : void */
    {
        $this->totalDiscountR = $discount;
    }

    public function getTotalDiscountPercentage() : float
    {
        return $this->totalDiscountR;
    }

    public function setDiscountQuantity($quantity) /* : void */
    {
        $this->discountQ = $quantity;
    }

    public function getDiscountQuantity() 
    {
        return $this->discountQ;
    }

    public function setSingleNetPrice(Money $price) /* : void */
    {
        $this->singlePriceNet = $price;
    }

    public function getSingleNetPrice() : Money
    {
        return $this->singlePriceNet;
    }

    public function setTotalNetPrice(Money $price) /* : void */
    {
        $this->totalPriceNet = $price;
    }

    public function getTotalNetPrice() : Money
    {
        return $this->totalPriceNet;
    }

    public function setTaxPrice(Money $tax) /* : void */
    {
        $this->taxP = $tax;
    }

    public function getTaxPrice() : Money
    {
        return $this->taxP;
    }

    public function setTaxPercentag(float $tax) /* : void */
    {
        $this->taxR = $tax;
    }

    public function getTaxPercentag() : float
    {
        return $this->taxR;
    }

    public function setSingleGrossPrice(Money $price) /* : void */
    {
        $this->singlePriceGross = $price;
    }

    public function getSingleGrossPrice() : Money
    {
        return $this->singlePriceGross;
    }

    public function setTotalGrossPrice(Money $price) /* : void */
    {
        $this->totalPriceGross = $price;
    }

    public function getTotalGrossPrice() : Money
    {
        return $this->totalPriceGross;
    }

    public function jsonSerialize()
    {
        
    }
}