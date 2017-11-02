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

namespace phpOMS\Localization;

use phpOMS\Stdlib\Base\Exception\InvalidEnumValue;
use phpOMS\Utils\Converter\AngleType;
use phpOMS\Utils\Converter\TemperatureType;

/**
 * Localization class.
 *
 * @category   Framework
 * @package    phpOMS\Localization
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Localization
{

    /**
     * Country ID.
     *
     * @var string
     * @since 1.0.0
     */
    private $country = ISO3166TwoEnum::_USA;
    /**
     * Timezone.
     *
     * @var string
     * @since 1.0.0
     */
    private $timezone = 'America/New_York';
    /**
     * Language ISO code.
     *
     * @var string
     * @since 1.0.0
     */
    private $language = ISO639x1Enum::_EN;
    /**
     * Currency.
     *
     * @var string
     * @since 1.0.0
     */
    private $currency = ISO4217Enum::_USD;
    /**
     * Number format.
     *
     * @var string
     * @since 1.0.0
     */
    private $decimal = '.';
    /**
     * Number format.
     *
     * @var string
     * @since 1.0.0
     */
    private $thousands = ',';

    /**
     * Angle type.
     *
     * @var string
     * @since 1.0.0
     */
    private $angle = AngleType::DEGREE;

    /**
     * Temperature type.
     *
     * @var string
     * @since 1.0.0
     */
    private $temperature = TemperatureType::CELSIUS;

    /**
     * Time format.
     *
     * @var string
     * @since 1.0.0
     */
    private $datetime = 'Y-m-d H:i:s';

    /**
     * Weight.
     *
     * @var string
     * @since 1.0.0
     */
    private $weight = [];

    /**
     * Speed.
     *
     * @var string
     * @since 1.0.0
     */
    private $speed = [];

    /**
     * Length.
     *
     * @var string
     * @since 1.0.0
     */
    private $length = [];

    /**
     * Area.
     *
     * @var string
     * @since 1.0.0
     */
    private $area = [];

    /**
     * Volume.
     *
     * @var string
     * @since 1.0.0
     */
    private $volume = [];

    /**
     * Constructor.
     *
     * @since  1.0.0
     */
    public function __construct()
    {
    }

    /**
     * @return string
     *
     * @since  1.0.0
     */
    public function getCountry() : string
    {
        return $this->country;
    }

    /**
     * @param string $country
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setCountry(string $country) /* : void */
    {
        if (!ISO3166TwoEnum::isValidValue($country)) {
            throw new InvalidEnumValue($country);
        }

        $this->country = $country;
    }

    /**
     * @return string
     *
     * @since  1.0.0
     */
    public function getTimezone() : string
    {
        return $this->timezone;
    }

    /**
     * @param string $timezone
     *
     * @todo   : maybe make parameter int
     *
     * @since  1.0.0
     */
    public function setTimezone(string $timezone) /* : void */
    {
        if (!TimeZoneEnumArray::isValidValue($timezone)) {
            throw new InvalidEnumValue($timezone);
        }

        $this->timezone = $timezone;
    }

    /**
     * @return string
     *
     * @since  1.0.0
     */
    public function getLanguage() : string
    {
        return $this->language;
    }

    /**
     * @param string $language
     *
     * @return void
     *
     * @throws InvalidEnumValue
     *
     * @since  1.0.0
     */
    public function setLanguage(string $language) /* : void */
    {
        $language = strtolower($language);
        
        if (!ISO639x1Enum::isValidValue($language)) {
            throw new InvalidEnumValue($language);
        }

        $this->language = $language;
    }

    /**
     * @return string
     *
     * @since  1.0.0
     */
    public function getCurrency() : string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setCurrency(string $currency) /* : void */
    {
        if (!ISO4217Enum::isValidValue($currency)) {
            throw new InvalidEnumValue($currency);
        }

        $this->currency = $currency;
    }

    /**
     * @return string
     *
     * @since  1.0.0
     */
    public function getDatetime() : string
    {
        return $this->datetime;
    }

    /**
     * @param string $datetime
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setDatetime(string $datetime) /* : void */
    {
        $this->datetime = $datetime;
    }

    /**
     * @return string
     *
     * @since  1.0.0
     */
    public function getDecimal() : string
    {
        return $this->decimal;
    }

    /**
     * @param string $decimal
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function setDecimal(string $decimal) /* : void */
    {
        $this->decimal = $decimal;
    }

    /**
     * @return string
     *
     * @since  1.0.0
     */
    public function getThousands() : string
    {
        return $this->thousands;
    }

    /**
     * @param string $thousands
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function setThousands(string $thousands) /* : void */
    {
        $this->thousands = $thousands;
    }

    /**
     * @return string
     *
     * @since  1.0.0
     */
    public function getAngle() : string
    {
        return $this->angle;
    }

    /**
     * @param string $angle
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function setAngle(string $angle) /* : void */
    {
        $this->angle = $angle;
    }

    /**
     * @return string
     *
     * @since  1.0.0
     */
    public function getTemperature() : string
    {
        return $this->temperature;
    }

    /**
     * @param string $temperature
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function setTemperature(string $temperature) /* : void */
    {
        $this->temperature = $temperature;
    }
}
