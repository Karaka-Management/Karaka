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

namespace phpOMS\Utils\EDI\AnsiX12\Components;

/**
 * EDI Header
 *
 * @link       https://www.erico.com/public/library/edi/ERICO850_4010.pdf
 * @category   Framework
 * @package    phpOMS\Utils\Converter
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class BIG
{
    private $invoiceDate = null;
    private $purchaseDate = null;
    private $invoice = '';
    private $purchase = '';
    private $transactionTypeCode = 0;

    public function setInvoiceDate(\DateTime $invoiceDate) /* : void */
    {
        $this->invoiceDate = $invoiceDate;
    }

    public function getInvoiceDate() : string
    {
        return $this->invoiceDate->format('Ymd');
    }

    public function setInvoiceNumber(string $invoice) /* : void */
    {
        if (strlen($invoice) < 1 || strlen($invoice) > 22) {
            throw new \Exception();
        }

        $this->invoice = $invoice;
    }

    public function getInvoiceNumber() : string
    {
        return $this->invoice;
    }

    public function setPurchaseDate(\DateTime $purchaseDate) /* : void */
    {
        $this->purchaseDate = $purchaseDate;
    }

    public function getPurchaseDate() : string
    {
        return $this->purchaseDate->format('Ymd');
    }

    public function setPurchaseNumber(string $purchase) /* : void */
    {
        if (strlen($purchase) < 1 || strlen($purchase) > 22) {
            throw new \Exception();
        }

        $this->purchase = $purchase;
    }

    public function getPurchaseNumber() : string
    {
        return $this->purchase;
    }

    public function setTransactionTypeCode(int $code) /* : void */
    {
        if ($code < 10 || $code > 99) {
            throw new \Exception();
        }
        
        $this->transactionTypeCode = $code;
    }

    public function getTransactionTypeCode() : string
    {
        return str_pad((string) $this->transactionTypeCode, 2, '0', STR_PAD_LEFT);
    }
}