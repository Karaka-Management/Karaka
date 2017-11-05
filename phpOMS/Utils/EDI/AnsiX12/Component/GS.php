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

namespace phpOMS\Utils\EDI\AnsiX12\Components;

/**
 * EDI Header
 *
 * @category   Framework
 * @package    phpOMS\Utils\Converter
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class GS
{
    private $functionalGroupHeader = 'GS';

    private $functionalIdentifierCode = FunctionalIdentifierCode::PO;

    private $applicationSenderCode = '';

    private $appicationReceiverCode = '';

    private $date = null;

    private $groupControlNumber = 0;

    private $responsibleAgencyCode = '';

    private $version = '';

    public function __construct()
    {
        $this->date = new \DateTime();
    }

    public function getFunctionalGroupHeader() : string
    {
        return $this->functionalGroupHeader;
    }

    public function getFunctionalIdentifierCode() : string
    {
        return $this->functionalIdentifierCode;
    }

    public function setFunctionalIdentifierCode(string $code) /* : void */
    {
        if (!FunctionalIdentifierCode::isValidValue($code)) {
            throw \Exception();
        }

        $this->functionalIdentifierCode = $code;
    }

    public function getApplicationSenderCode() : string
    {
        return str_pad((string) $this->applicationSenderCode, 2, '0', STR_PAD_LEFT);
    }

    public function setApplicationSenderCode(string $code) /* : void */
    {
        if (strlen($code) < 2 || strlen($code) > 15) {
            throw new \Exception();
        }

        $this->applicationSenderCode = $code;
    }

    public function getApplicationReceiverCode() : string
    {
        return str_pad((string) $this->applicationReceiverCode, 2, '0', STR_PAD_LEFT);
    }

    public function setApplicationReceiverCode(string $code) /* : void */
    {
        if (strlen($code) < 2 || strlen($code) > 15) {
            throw new \Exception();
        }

        $this->applicationReceiverCode = $code;
    }

    public function setDate(\DateTime $date) /* : void */
    {
        $this->date = $date;
    }

    public function getDate() : string
    {
        return $this->date->format('d:m:y');
    }

    public function getTime() : string
    {
        return $this->date->format('d:m:y');
    }

    public function getGroupControlNumber() : int
    {
        return $this->groupControlNumber;
    }

    public function setGroupControlNumber(int $number) /* : void */
    {
        if ($number < 0) {
            throw new \Exception();
        }

        $this->groupControlNumber = $number;
    }

    public function getResponsibleAgencyCode() : int
    {
        return $this->responsibleAgencyCode;
    }

    public function setResponsibleAgencyCode(int $code) /* : void */
    {
        if ($code < 0 || $code > 99) {
            throw new \Exception();
        }

        $this->responsibleAgencyCode = $code;
    }

    public function getVersion() : string
    {
        return $this->version;
    }

    public function setVersion(string $version) /* : void */
    {
        $this->version = $version;
    }

    public function serialize()
    {
        return $this->functionalGroupHeader . '*'
            . $this->getFunctionalIdentifierCode() . '*'
            . $this->getApplicationSenderCode() . '*'
            . $this->getApplicationReceiverCode() . '*'
            . $this->getDate() . '*'
            . $this->getTime() . '*'
            . $this->getGroupControlNumber() . '*'
            . $this->getResponsibleAgencyCode() . '*'
            . $this->getVersion() . '*' . self::COMPONENT_ELEMENT_SEPARATOR;
    }

    public function unserialize($raw)
    {
        $split = explode($raw, '*');

        $this->setFunctionalGroupHeader(trim($split[0]));
        $this->setFunctionalIdentifierCode(trim($split[1]));
        $this->setApplicationSenderCode(trim($split[2]));
        $this->setApplicationReceiverCode(trim($split[3]));
        $this->setDate(new \DateTime(trim($split[4]) . '-' . trim($split[5])));
        $this->setGroupControlNumber(trim($split[6]));
        $this->setResponsibleAgencyCode((int) trim($split[7]));
        $this->setVersion(trim($split[8]));
    }
}
