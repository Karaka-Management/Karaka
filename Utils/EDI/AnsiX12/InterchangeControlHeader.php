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

namespace phpOMS\Utils\EDI\AnsiX12;

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
class InterchangeControlHeader
{
    /* private */ const COMPONENT_ELEMENT_SEPARATOR = '>';

    private $interchangeControlHeader = InterchangeControlHeader::ISA;

    /**
     * Code to identify the type of information in the Authorization Information.
     *
     * Req: M
     * Type: ID
     * Min/Max: 2/2
     * Usage: Must
     *
     * 00 = No Authorization Information available
     *
     * @var int
     * @since 1.0.0
     */
    private $authorizationInformationQualifier = 0;


    /**
     * Information used for additional identification or authorization of the interchange
     * sender or the data in the interchange; the type of information is set by the Authorization
     * Information Qualifier.
     *
     * Req: M
     * Type: AN
     * Min/Max: 10/10
     * Usage: Must
     *
     * @var string
     * @since 1.0.0
     */
    private $authorizationInformation = '';

    /**
     * Code to identify the type of information in the Security Information.
     *
     * Req: M
     * Type: ID
     * Min/Max: 2/2
     * Usage: Must
     *
     * 00 = No Security Information available
     *
     * @var int
     * @since 1.0.0
     */
    private $securityInformationQualifer = 0;

    /**
     * This is used for identifying the security information about the interchange
     * sender or the data in the interchange; the type of information is set by the Security
     * Information Qualifier.
     *
     * Req: M
     * Type: AN
     * Min/Max: 10/10
     * Usage: Must
     *
     * @var string
     * @since 1.0.0
     */
    private $securityInformation = '';

    /**
     * Qualifier to designate the system/method of code structure used to designate
     * the sender or receiver ID element being qualifiedn.
     *
     * Req: M
     * Type: ID
     * Min/Max: 2/2
     * Usage: Must
     *
     * 00 = No Security Information available
     *
     * @var int
     * @since 1.0.0
     */
    private $interchangeIdQualifier = 0;

    /**
     * Interchange Sender
     *
     * Req: M
     * Type: AN
     * Min/Max: 15/15
     * Usage: Must
     *
     * @var string
     * @since 1.0.0
     */
    private $interchangeSender = '';

    /**
     * DateTime of the interchange
     *
     * Req: M
     * Type: DTM
     * Usage: Must
     *
     * @var \DateTime
     * @since 1.0.0
     */
    private $interchangeDateTime = null;

    /**
     * Code to identify the agency responsible for the control standard used by the
     * message that is enclosed by the interchange header and trailer.
     *
     * Req: M
     * Type: ID
     * Min/Max: 1/1
     * Usage: Must
     *
     * @var string
     * @since 1.0.0
     */
    private $interchangeControlStandardId = '';

    /**
     * Code specifying the version number of the interchange control segments.
     *
     * Req: M
     * Type: ID
     * Min/Max: 5/5
     * Usage: Must
     *
     * @var int
     * @since 1.0.0
     */
    private $interchangeControlVersionNumber = 401;

    /**
     * A control number assigned by the interchange sender.
     *
     * Req: M
     * Type: int
     * Min/Max: 9/9
     * Usage: Must
     *
     * @var int
     * @since 1.0.0
     */
    private $interchangeControlNumber = 0;

    /**
     * Code sent by the sender to request an interchange acknowledgment.
     *
     * Req: M
     * Type: bool
     * Min/Max: 1/1
     * Usage: Must
     *
     * @var bool
     * @since 1.0.0
     */
    private $acknowledgementRequested = false;

    /**
     * Code to indicate whether data enclosed by this interchange envelope is test,
     * production or information.
     *
     * Req: M
     * Type: ID
     * Min/Max: 1/1
     * Usage: Must
     *
     * @var int
     * @since 1.0.0
     */
    private $usageIndicator = 'T';

    public function setInterchangeControlHeader(string $header) /* : void */
    {
        $this->interchangeControlHeader = $header;
    }

    public function setAuthorizationInformationQualifier(int $qualifer) /* : void */
    {
        if ($qualifer > 99) {
            throw new \Exception();
        } 

        $this->authorizationInformationQualifier = $qualifier;
    }

    public function getAuthorizationInformationQualifier() : string
    {
        return str_pad((string) $this->authorizationInformationQualifier, 2, '0', STR_PAD_LEFT);
    }

    public function setAuthorizationInformation(string $information) /* : void */
    {
        if (strlen($information) > 10) {
            throw new \Exception();
        } 

        $this->authorizationInformation = $information;
    }

    public function getAuthorizationInformation() : string
    {
        return str_pad((string) $this->authorizationInformation, 10, ' ', STR_PAD_RIGHT);
    }

    public function setSecurityInformationQualifer(int $qualifer) /* : void */
    {
        if ($qualifer > 99) {
            throw new \Exception();
        } 

        $this->securityInformationQualifer = $qualifier;
    }

    public function getSecurityInformationQualifer() : string
    {
        return str_pad((string) $this->securityInformationQualifer, 2, '0', STR_PAD_LEFT);
    }

    public function setSecurityInformation(string $information) /* : void */
    {
        if (strlen($information) > 10) {
            throw new \Exception();
        } 

        $this->securityInformation = $information;
    }

    public function getSecurityInformation() : string
    {
        return str_pad((string) $this->securityInformation, 10, ' ', STR_PAD_RIGHT);
    }

    public function setInterchangeIdQualifier(int $qualifer) /* : void */
    {
        if ($qualifer > 99) {
            throw new \Exception();
        } 

        $this->interchangeIdQualifier = $qualifier;
    }

    public function getInterchangeIdQualifier() : string
    {
        return str_pad((string) $this->interchangeIdQualifier, 2, '0', STR_PAD_LEFT);
    }


    public function setInterchangeSender(string $information) /* : void */
    {
        if (strlen($information) > 15) {
            throw new \Exception();
        } 

        $this->interchangeSender = $information;
    }

    public function getInterchangeSender() : string
    {
        return str_pad((string) $this->interchangeSender, 15, ' ', STR_PAD_RIGHT);
    }

    public function setInterchangeReceiver(string $information) /* : void */
    {
        if (strlen($information) > 15) {
            throw new \Exception();
        } 

        $this->interchangeReceiver = $information;
    }

    public function getInterchangeReceiver() : string
    {
        return str_pad((string) $this->interchangeReceiver, 15, ' ', STR_PAD_RIGHT);
    }

    public function setInterchangeDatetime(\DateTime $interchange) /* : void */
    {
        $this->interchangeDateTime = $interchange;
    }

    public function getInterchangeDate() : string
    {
        return $this->interchangeDateTime->format('d:m:y');
    }

    public function getInterchangeTime() : string
    {
        return $this->interchangeDateTime->format('H:i');
    }

    public function setInterchangeControlStandardId(string $id) /* : void */
    {
        if (strlen($id) !== 1) {
            throw new \Exception();
        } 

        $this->interchangeControlStandardId = $id;
    }

    public function getInterchangeControlStandardId() : string
    {
        return $this->interchangeControlStandardId;
    }

    public function setInterchangeControlVersionNumber(int $version) /* : void */
    {
        if ($version > 99999) {
            throw new \Exception();
        } 

        $this->interchangeControlVersionNumber = $version;
    }

    public function getInterchangeControlVersionNumber() : string
    {
        return str_pad((string) $this->interchangeControlVersionNumber, 5, '0', STR_PAD_LEFT);
    }

    public function setInterchangeControlNumber(int $number) /* : void */
    {
        if ($number > 999999999) {
            throw new \Exception();
        } 

        $this->interchangeControlNumber = $number;
    }

    public function getInterchangeControlNumber() : string
    {
        return str_pad((string) $this->interchangeControlNumber, 9, '0', STR_PAD_LEFT);
    }

    public function setAcknowledgmentRequested(bool $ack) /* : void */
    {
        $this->acknowledgmentRequested = $ack;
    }

    public function getAcknowledgmentRequested() : string
    {
        return (string) $this->acknowledgmentRequested;
    }

    public function setUsageUndicator(string $id) /* : void */
    {
        if (strlen($id) !== 1) {
            throw new \Exception();
        } 

        $this->usageIndicator = $id;
    }

    public function getUsageUndicator() : string
    {
        return $this->usageIndicator;
    }

    public function serialize()
    {
        return $this->interchangeControlHeader . '*'
            . $this->getAuthorizationInformationQualifier() . '*'
            . $this->getAuthorizationInformation() . '*'
            . $this->getSecurityInformationQualifer() . '*'
            . $this->getSecurityInformation() . '*'
            . $this->getInterchangeIdQualifier() . '*'
            . $this->getInterchangeSender() . '*'
            . $this->getInterchangeIdQualifier() . '*'
            . $this->getInterchangeReceiver() . '*'
            . $this->getInterchangeDate() . '*'
            . $this->getInterchangeTime() . '*'
            . $this->getInterchangeControlStandardId() . '*'
            . $this->getInterchangeControlVersionNumber() . '*'
            . $this->getInterchangeControlNumber() . '*'
            . $this->getAcknowledgmentRequested() . '*'
            . $this->getUsageUndicator() . '*' . self::COMPONENT_ELEMENT_SEPARATOR;
    }

    public function unserialize($raw)
    {
        $split = explode($raw);

        $this->setInterchangeControlHeader(trim($split[0]));
        $this->setAuthorizationInformationQualifier((int) trim($split[1]));
        $this->setAuthorizationInformation(trim($split[2]));
        $this->setSecurityInformationQualifer((int) trim($split[3]));
        $this->setSecurityInformation(trim($split[4]));
        $this->setInterchangeIdQualifier((int) trim($split[5]));
        $this->setInterchangeSender(trim($split[6]));
        $this->setInterchangeReceiver(trim($split[8]));
        $this->setInterchangeDatetime(new \DateTime(trim($split[9]) . '-' . trim($split[10])));
        $this->setInterchangeControlStandardId(trim($split[11]));
        $this->setInterchangeControlVersionNumber((int) trim($split[12]));
        $this->setInterchangeControlNumber((int) trim($split[13]));
        $this->setAcknowledgmentRequested((bool) $split[14]);
        $this->setUsageUndicator($split[15]);
    }
}
