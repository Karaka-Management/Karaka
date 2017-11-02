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

namespace phpOMS\Utils\Barcode;

/**
 * Aztec class.
 *
 * @category   Log
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class HIBCC
{
    private $identifier = '';
    private $productId = '';
    private $measureOfUnit = 0;
    private $dateFormat = '';
    private $expirationDate = null;
    private $productionDate = null;
    private $lot = '';
    private $checkValue = 0;

    public function __construct()
    {

    }

    public function setIdentifier(string $identifier) /* : void */
    {
        $this->identifier = $identifier;
    }

    public function getIdentifier() : string
    {
        return $this->identifier;
    }

    public function setProductId(string $id) /* : void */
    {
        $this->productId = $id;
    }

    public function getProductId() : string
    {
        return $this->productId;
    }

    public function setMeasureOfUnit(int $measure) /* : void */
    {
        $this->measureOfUnit = $measure;
    }

    public function getMeasureOfUnit() : int
    {
        return $this->measureOfUnit;
    }

    public function setDateFormat(string $format) /* : void */
    {
        $this->dateFormat = $format;
    }

    public function getDateFormat() : string
    {
        return $this->dateFormat();
    }

    public function setExpirationDate(\DateTime $date) /* : void */
    {
        $this->expirationDate = $date;
    }

    public function getExpirationDate() : \DateTime
    {
        return $this->expirationDate;
    }

    public function setPrductionDate(\DateTime $date) /* : void */
    {
        $this->productionDate = $date;
    }

    public function getProductionDate() : \DateTime
    {
        return $this->productionDate;
    }

    public function setLOT(string $lot) /* : void */
    {
        $this->lot = $lot;
    }

    public function getLOT() : string
    {
        return $this->lot;
    }

    public function getCheckValue() : int
    {
        return $this->checkValue;
    }

    public function getPrimaryDI() : string
    {
        return '';
    }

    public function getSecondaryDI() : string
    {
        return '';
    }


}
