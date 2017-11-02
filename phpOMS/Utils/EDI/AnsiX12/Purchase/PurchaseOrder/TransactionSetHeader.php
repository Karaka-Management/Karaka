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

namespace phpOMS\Utils\EDI\AnsiX12\Purchase\PurchaseOrder;

/**
 * EDI 850 - Purchase order.
 *
 * @category   Framework
 * @package    phpOMS\Utils\Converter
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class TransactionSetHeader
{
    /* private */ const IDENTIFIER = 'ST';
    
    private $transactionSetIdentifierCode = 850;

    private $transactionSetControlNumber = '';

    public function getTransactionSetIdentiferCode() : int
    {
        return $this->transactionSetIdentifierCode;
    }

    public function setTransactionIdentifierCode(int $code) /* : void */
    {
        $this->transactionSetIdentifierCode = $code;
    }

    public function getTransactionSetControlNumber() : string
    {
        return str_pad((string) $this->transactionSetControlNumber, 9, '0', STR_PAD_LEFT);
    }

    public function setTransactionSetControlNumber(string $number) /* : void */
    {
        if (strlen($number) < 4 || strlen($number) > 9) {
            throw new \Exception();
        }

        $this->transactionSetControlNumber = $number;
    }

    public function unserialize($raw)
    {
        $split = explode($raw);

        $this->setTransactionSetIdentifierCode((int) trim($split[1]));
        $this->setTransactionSetControlNumber(trim($split[2]));
    }

    public function serialize()
    {
        return self::IDENTIFIER . '*'
            . $this->getTransactionSetIdentifierCode() . '*'
            . $this->getTransactionSetControlNumber();
    }
}
