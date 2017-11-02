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
 * @category   Framework
 * @package    phpOMS\Utils\Converter
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class ST
{
    /* private */ const IDENTIFIER = 'ST';

    private $transactionSetIdentifierCode = 0;

    private $transactionSetControlNumber = '';

    public function __construct(int $idCode = 0) 
    {
        $this->transactionSetIdentifierCode = $idCode;
    }

    public function setTransactionSetIdentifierCode(int $idCode)
    {
        if ($idCode < 100 || $idCode > 999) {
            throw new \Exception();
        } 

        $this->transactionSetIdentifierCode = $idCode;
    }

    public function getTransactionSetIdentifierCode() : int
    {
        return $this->transactionSetIdentifierCode;
    }

    public function setTransactionSetControlNumber(string $controlNumber)
    {
        if (strlen($controlNumber) < 4 || strlen($controlNumber) > 9) {
            throw new \Exception();
        } 

        $this->transactionSetControlNumber = $controlNumber;
    }

    public function getTransactionSetControlNumber() : string
    {
        return str_pad((string) $this->transactionSetControlNumber, 9, '0', STR_PAD_LEFT);
    }

    public function serialize()
    {
        return self::IDENTIFIER . '*'
            . $this->getTransactionSetIdentifierCode() . '*'
            . $this->getTransactionSetControlNumber() . '*' . self::COMPONENT_ELEMENT_SEPARATOR;
    }

    public function unserialize($raw)
    {
        $split = explode('*', $raw);

        $this->setTransactionSetIdentifierCode((int) $split[1]);
        $this->setTransactionSetControlNumber(substr($split[2], -1));
    }
}