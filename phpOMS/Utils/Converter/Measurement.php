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

namespace phpOMS\Utils\Converter;

/**
 * Measurement converter.
 *
 * @category   Framework
 * @package    phpOMS\Utils\Converter
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Measurement
{
    /**
     * Constructor.
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    private function __construct()
    {
    }

    /**
     * Convert temperature.
     *
     * @param float  $value Value to convert
     * @param string $from  Input temperature
     * @param string $to    Output temperature
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function convertTemperature(float $value, string $from = TemperatureType::FAHRENHEIT, string $to = TemperatureType::CELSIUS) : float
    {
        // to kelving
        $value = self::normalizeTemperature($value, $from);

        switch ($to) {
            case TemperatureType::KELVIN:
                break;
            case TemperatureType::CELSIUS:
                $value -= 273.15;
                break;
            case TemperatureType::FAHRENHEIT:
                $value = (($value - 273.15) * 1.8) + 32;
                break;
            case TemperatureType::REAUMUR:
                $value = ($value - 273.15) * 0.8;
                break;
            case TemperatureType::RANKINE:
                $value = ($value - 273.15) * 1.8 + 491.67;
                break;
            case TemperatureType::DELISLE:
                $value = ($value - 273.15) * 1.5 - 100;
                break;
            case TemperatureType::NEWTON:
                $value = ($value - 273.15) * 0.33;
                break;
            case TemperatureType::ROMER:
                $value = ($value - 273.15) * 0.525 + 7.5;
                break;
            default:
                throw new \InvalidArgumentException('Temperature not supported');
        }

        return $value;
    }

    /**
     * Convert temperature.
     *
     * @param float  $value Value to convert
     * @param string $from  Input temperature
     *
     * @return float
     *
     * @since  1.0.0
     */
    private static function normalizeTemperature(float $value, string $from) : float
    {
        switch ($from) {
            case TemperatureType::KELVIN:
                break;
            case TemperatureType::CELSIUS:
                $value += 273.15;
                break;
            case TemperatureType::FAHRENHEIT:
                $value = ($value - 32) / 1.8 + 273.5;
                break;
            case TemperatureType::REAUMUR:
                $value = $value / 0.8 + 273.15;
                break;
            case TemperatureType::RANKINE:
                $value = ($value - 491.67) / 1.8 + 273.15;
                break;
            case TemperatureType::DELISLE:
                $value = ($value + 100) / 1.5 + 273.15;
                break;
            case TemperatureType::NEWTON:
                $value = $value / 0.33 + 273.15;
                break;
            case TemperatureType::ROMER:
                $value = ($value - 7.5) / 0.525 + 273.15;
                break;
            default:
                throw new \InvalidArgumentException('Temperature not supported');
        }

        return $value;
    }

    /**
     * Convert weight.
     *
     * @param float  $value Value to convert
     * @param string $from  Input weight
     * @param string $to    Output weight
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function convertWeight(float $value, string $from = WeightType::GRAM, string $to = WeightType::KILOGRAM) : float
    {
        // to gram
        $value = self::normalizeWeight($value, $from);

        switch ($to) {
            case WeightType::GRAM:
                break;
            case WeightType::MICROGRAM:
                $value *= 1000000;
                break;
            case WeightType::MILLIGRAM:
                $value *= 1000;
                break;
            case WeightType::KILOGRAM:
                $value /= 1000;
                break;
            case WeightType::METRIC_TONS:
                $value /= 1000000;
                break;
            case WeightType::STONES:
                $value *= 0.15747 * 1000;
                break;
            case WeightType::OUNCES:
                $value *= 0.035274;
                break;
            case WeightType::POUNDS:
                $value *= 0.0022046;
                break;
            case WeightType::GRAIN:
                $value *= 15.432;
                break;
            case WeightType::CARAT:
                $value *= 5.0;
                break;
            case WeightType::LONG_TONS:
                $value *= 9.8420653e-07;
                break;
            case WeightType::SHORT_TONS:
                $value *= 1.1023113e-06;
                break;
            case WeightType::TROY_POUNDS:
                $value *= 0.0026792;
                break;
            case WeightType::TROY_OUNCES:
                $value *= 0.032151;
                break;
            default:
                throw new \InvalidArgumentException('Weight not supported');
        }

        return $value;
    }

    /**
     * Convert weight.
     *
     * @param float  $value Value to convert
     * @param string $from  Input weight
     *
     * @return float
     *
     * @since  1.0.0
     */
    private static function normalizeWeight(float $value, string $from) : float
    {
        switch ($from) {
            case WeightType::GRAM:
                break;
            case WeightType::MICROGRAM:
                $value /= 1000000;
                break;
            case WeightType::MILLIGRAM:
                $value /= 1000;
                break;
            case WeightType::KILOGRAM:
                $value *= 1000;
                break;
            case WeightType::METRIC_TONS:
                $value *= 1000000;
                break;
            case WeightType::STONES:
                $value /= 0.15747 * 1000;
                break;
            case WeightType::OUNCES:
                $value /= 0.035274;
                break;
            case WeightType::POUNDS:
                $value /= 0.0022046;
                break;
            case WeightType::GRAIN:
                $value /= 15.432;
                break;
            case WeightType::CARAT:
                $value /= 5.0;
                break;
            case WeightType::LONG_TONS:
                $value /= 9.8420653e-07;
                break;
            case WeightType::SHORT_TONS:
                $value /= 1.1023113e-06;
                break;
            case WeightType::TROY_POUNDS:
                $value /= 0.0026792;
                break;
            case WeightType::TROY_OUNCES:
                $value /= 0.032151;
                break;
            default:
                throw new \InvalidArgumentException('Weight not supported');
        }

        return $value;
    }

    /**
     * Convert length.
     *
     * @param float  $value Value to convert
     * @param string $from  Input length
     * @param string $to    Output length
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function convertLength(float $value, string $from = LengthType::METERS, string $to = LengthType::KILOMETERS) : float
    {
        // to meter
        $value = self::normalizeLength($value, $from);

        switch ($to) {
            case LengthType::METERS:
                break;
            case LengthType::MILES:
                $value *= 0.00062137;
                break;
            case LengthType::MICROMETER:
                $value *= 1000000;
                break;
            case LengthType::CENTIMETERS:
                $value *= 100;
                break;
            case LengthType::MILLIMETERS:
                $value *= 1000;
                break;
            case LengthType::KILOMETERS:
                $value /= 1000;
                break;
            case LengthType::CHAINS:
                $value *= 0.049710;
                break;
            case LengthType::FEET:
                $value *= 3.2808;
                break;
            case LengthType::FURLONGS:
                $value *= 0.0049710;
                break;
            case LengthType::MICROINCH:
                $value *= 39370000;
                break;
            case LengthType::INCHES:
                $value *= 39.370;
                break;
            case LengthType::YARDS:
                $value *= 1.0936;
                break;
            case LengthType::PARSECS:
                $value *= 3.2407793e-17;
                break;
            case LengthType::UK_NAUTICAL_MILES:
                $value *= 0.00053961;
                break;
            case LengthType::US_NAUTICAL_MILES:
                $value *= 0.00053996;
                break;
            case LengthType::UK_NAUTICAL_LEAGUES:
                $value *= 0.00017987;
                break;
            case LengthType::UK_LEAGUES:
                $value *= 0.00020700;
                break;
            case LengthType::US_LEAGUES:
                $value *= 0.00020712;
                break;
            case LengthType::NAUTICAL_LEAGUES:
                $value *= 0.00017999;
                break;
            case LengthType::LIGHTYEARS:
                $value *= 1.0570008e-16;
                break;
            case LengthType::DECIMETERS:
                $value *= 10;
                break;
            default:
                throw new \InvalidArgumentException('Length not supported');
        }

        return $value;
    }

    /**
     * Convert length.
     *
     * @param float  $value Value to convert
     * @param string $from  Input length
     *
     * @return float
     *
     * @since  1.0.0
     */
    private static function normalizeLength(float $value, string $from) : float
    {
        switch ($from) {
            case LengthType::METERS:
                break;
            case LengthType::MILES:
                $value /= 0.00062137;
                break;
            case LengthType::MICROMETER:
                $value /= 1000000;
                break;
            case LengthType::CENTIMETERS:
                $value /= 100;
                break;
            case LengthType::MILLIMETERS:
                $value /= 1000;
                break;
            case LengthType::KILOMETERS:
                $value *= 1000;
                break;
            case LengthType::CHAINS:
                $value /= 0.049710;
                break;
            case LengthType::FEET:
                $value /= 3.2808;
                break;
            case LengthType::FURLONGS:
                $value /= 0.0049710;
                break;
            case LengthType::MICROINCH:
                $value /= 39370000;
                break;
            case LengthType::INCHES:
                $value /= 39.370;
                break;
            case LengthType::YARDS:
                $value /= 1.0936;
                break;
            case LengthType::PARSECS:
                $value /= 3.2407793e-17;
                break;
            case LengthType::UK_NAUTICAL_MILES:
                $value /= 0.00053961;
                break;
            case LengthType::US_NAUTICAL_MILES:
                $value /= 0.00053996;
                break;
            case LengthType::UK_NAUTICAL_LEAGUES:
                $value /= 0.00017987;
                break;
            case LengthType::UK_LEAGUES:
                $value /= 0.00020700;
                break;
            case LengthType::US_LEAGUES:
                $value /= 0.00020712;
                break;
            case LengthType::NAUTICAL_LEAGUES:
                $value /= 0.00017999;
                break;
            case LengthType::LIGHTYEARS:
                $value /= 1.0570008e-16;
                break;
            case LengthType::DECIMETERS:
                $value /= 10;
                break;
            default:
                throw new \InvalidArgumentException('Length not supported');
        }

        return $value;
    }

    /**
     * Convert area.
     *
     * @param float  $value Value to convert
     * @param string $from  Input length
     * @param string $to    Output length
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function convertArea(float $value, string $from = AreaType::SQUARE_METERS, string $to = AreaType::SQUARE_KILOMETERS) : float
    {
        // to square meter
        $value = self::normalizeArea($value, $from);

        switch ($to) {
            case AreaType::SQUARE_METERS:
                break;
            case AreaType::SQUARE_FEET:
                $value *= 10.764;
                break;
            case AreaType::SQUARE_KILOMETERS:
                $value /= 1000000;
                break;
            case AreaType::SQUARE_MILES:
                $value *= 3.8610216e-07;
                break;
            case AreaType::SQUARE_YARDS:
                $value *= 1.1960;
                break;
            case AreaType::SQUARE_INCHES:
                $value *= 1550;
                break;
            case AreaType::SQUARE_MICROINCHES:
                $value *= 1.550031e+15;
                break;
            case AreaType::SQUARE_CENTIMETERS:
                $value *= 10000;
                break;
            case AreaType::SQUARE_MILIMETERS:
                $value *= 1000000;
                break;
            case AreaType::SQUARE_MICROMETERS:
                $value *= 1000000000000;
                break;
            case AreaType::SQUARE_DECIMETERS:
                $value *= 100;
                break;
            case AreaType::HECTARES:
                $value /= 10000;
                break;
            case AreaType::ACRES:
                $value *= 0.00024711;
                break;
            default:
                throw new \InvalidArgumentException('Area not supported');
        }

        return $value;
    }

    /**
     * Convert area.
     *
     * @param float  $value Value to convert
     * @param string $from  Input length
     *
     * @return float
     *
     * @since  1.0.0
     */
    private static function normalizeArea(float $value, string $from) : float
    {
        switch ($from) {
            case AreaType::SQUARE_METERS:
                break;
            case AreaType::SQUARE_FEET:
                $value /= 10.764;
                break;
            case AreaType::SQUARE_KILOMETERS:
                $value *= 1000000;
                break;
            case AreaType::SQUARE_MILES:
                $value /= 3.8610216e-07;
                break;
            case AreaType::SQUARE_YARDS:
                $value /= 1.1960;
                break;
            case AreaType::SQUARE_INCHES:
                $value /= 1550;
                break;
            case AreaType::SQUARE_MICROINCHES:
                $value /= 1.550031e+15;
                break;
            case AreaType::SQUARE_CENTIMETERS:
                $value /= 10000;
                break;
            case AreaType::SQUARE_MILIMETERS:
                $value /= 1000000;
                break;
            case AreaType::SQUARE_MICROMETERS:
                $value /= 1000000000000;
                break;
            case AreaType::SQUARE_DECIMETERS:
                $value /= 100;
                break;
            case AreaType::HECTARES:
                $value *= 10000;
                break;
            case AreaType::ACRES:
                $value /= 0.00024711;
                break;
            default:
                throw new \InvalidArgumentException('Area not supported');
        }

        return $value;
    }

    /**
     * Convert volume.
     *
     * @param float  $value Value to convert
     * @param string $from  Input volume
     * @param string $to    Output volume
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function convertVolume(float $value, string $from = VolumeType::LITER, string $to = VolumeType::LITER) : float
    {
        // to square meter
        $value = self::normalizeVolume($value, $from);

        switch ($to) {
            case VolumeType::LITER:
                break;
            case VolumeType::US_GALLON_LIQUID:
                $value *= 0.26417;
                break;
            case VolumeType::UK_GALLON:
                $value *= 0.21997;
                break;
            case VolumeType::US_PINT_LIQUID:
                $value *= 2.1134;
                break;
            case VolumeType::UK_PINT:
                $value *= 1.7598;
                break;
            case VolumeType::CENTILITER:
                $value *= 100;
                break;
            case VolumeType::MILLILITER:
                $value *= 1000;
                break;
            case VolumeType::CUBIC_METER:
                $value /= 1000;
                break;
            case VolumeType::UK_BARREL:
                $value *= 0.0061103;
                break;
            case VolumeType::US_GALLON_DRY:
                $value *= 0.22702;
                break;
            case VolumeType::CUBIC_FEET:
                $value *= 0.035315;
                break;
            case VolumeType::US_QUARTS_LIQUID:
                $value *= 1.0567;
                break;
            case VolumeType::US_QUARTS_DRY:
                $value *= 0.90808;
                break;
            case VolumeType::UK_QUARTS:
                $value *= 0.87988;
                break;
            case VolumeType::US_PINT_DRY:
                $value *= 1.8162;
                break;
            case VolumeType::US_CUP:
                $value *= 4.2268;
                break;
            case VolumeType::CAN_CUP:
                $value *= 4.3994;
                break;
            case VolumeType::METRIC_CUP:
                $value *= 4;
                break;
            case VolumeType::US_GILL:
                $value *= 8.4535;
                break;
            case VolumeType::US_TABLESPOON:
                $value *= 67.628;
                break;
            case VolumeType::UK_TABLESPOON:
                $value *= 70.390;
                break;
            case VolumeType::METRIC_TABLESPOON:
                $value *= 66.667;
                break;
            case VolumeType::US_TEASPOON:
                $value *= 202.88;
                break;
            case VolumeType::UK_TEASPOON:
                $value *= 281.56;
                break;
            case VolumeType::METRIC_TEASPOON:
                $value *= 200;
                break;
            case VolumeType::US_OUNCES:
                $value *= 33.814;
                break;
            case VolumeType::UK_OUNCES:
                $value *= 35.195;
                break;
            case VolumeType::CUBIC_INCH:
                $value *= 61.024;
                break;
            case VolumeType::CUBIC_CENTIMETER:
                $value *= 1000;
                break;
            case VolumeType::CUBIC_MILLIMETER:
                $value *= 1000000;
                break;
            case VolumeType::MICROLITER:
                $value *= 1000000;
                break;
            case VolumeType::KILOLITER:
                $value *= 1000;
                break;
            case VolumeType::UK_GILL:
                $value *= 7.0390;
                break;
            case VolumeType::CUBIC_YARD:
                $value *= 0.0013080;
                break;
            case VolumeType::US_BARREL_DRY:
                $value *= 0.0086485;
                break;
            case VolumeType::US_BARREL_LIQUID:
                $value *= 0.0083864;
                break;
            case VolumeType::US_BARREL_OIL:
                $value *= 0.0062898;
                break;
            case VolumeType::US_BARREL_FEDERAL:
                $value *= 0.0085217;
                break;
            default:
                throw new \InvalidArgumentException('Volume not supported');
        }

        return $value;
    }

    /**
     * Convert volume.
     *
     * @param float  $value Value to convert
     * @param string $from  Input volume
     *
     * @return float
     *
     * @since  1.0.0
     */
    private static function normalizeVolume(float $value, string $from) : float
    {
        switch ($from) {
            case VolumeType::LITER:
                break;
            case VolumeType::US_GALLON_LIQUID:
                $value /= 0.26417;
                break;
            case VolumeType::UK_GALLON:
                $value /= 0.21997;
                break;
            case VolumeType::US_PINT_LIQUID:
                $value /= 2.1134;
                break;
            case VolumeType::UK_PINT:
                $value /= 1.7598;
                break;
            case VolumeType::CENTILITER:
                $value /= 100;
                break;
            case VolumeType::MILLILITER:
                $value /= 1000;
                break;
            case VolumeType::CUBIC_METER:
                $value *= 1000;
                break;
            case VolumeType::UK_BARREL:
                $value /= 0.0061103;
                break;
            case VolumeType::US_GALLON_DRY:
                $value /= 0.22702;
                break;
            case VolumeType::CUBIC_FEET:
                $value /= 0.035315;
                break;
            case VolumeType::US_QUARTS_LIQUID:
                $value /= 1.0567;
                break;
            case VolumeType::US_QUARTS_DRY:
                $value /= 0.90808;
                break;
            case VolumeType::UK_QUARTS:
                $value /= 0.87988;
                break;
            case VolumeType::US_PINT_DRY:
                $value /= 1.8162;
                break;
            case VolumeType::US_CUP:
                $value /= 4.2268;
                break;
            case VolumeType::CAN_CUP:
                $value /= 4.3994;
                break;
            case VolumeType::METRIC_CUP:
                $value /= 4;
                break;
            case VolumeType::US_GILL:
                $value /= 8.4535;
                break;
            case VolumeType::US_TABLESPOON:
                $value /= 67.628;
                break;
            case VolumeType::UK_TABLESPOON:
                $value /= 70.390;
                break;
            case VolumeType::METRIC_TABLESPOON:
                $value /= 66.667;
                break;
            case VolumeType::US_TEASPOON:
                $value /= 202.88;
                break;
            case VolumeType::UK_TEASPOON:
                $value /= 281.56;
                break;
            case VolumeType::METRIC_TEASPOON:
                $value /= 200;
                break;
            case VolumeType::US_OUNCES:
                $value /= 33.814;
                break;
            case VolumeType::UK_OUNCES:
                $value /= 35.195;
                break;
            case VolumeType::CUBIC_INCH:
                $value /= 61.024;
                break;
            case VolumeType::CUBIC_CENTIMETER:
                $value /= 1000;
                break;
            case VolumeType::CUBIC_MILLIMETER:
                $value /= 1000000;
                break;
            case VolumeType::MICROLITER:
                $value /= 1000000;
                break;
            case VolumeType::KILOLITER:
                $value /= 1000;
                break;
            case VolumeType::UK_GILL:
                $value /= 7.0390;
                break;
            case VolumeType::CUBIC_YARD:
                $value /= 0.0013080;
                break;
            case VolumeType::US_BARREL_DRY:
                $value /= 0.0086485;
                break;
            case VolumeType::US_BARREL_LIQUID:
                $value /= 0.0083864;
                break;
            case VolumeType::US_BARREL_OIL:
                $value /= 0.0062898;
                break;
            case VolumeType::US_BARREL_FEDERAL:
                $value /= 0.0085217;
                break;
            default:
                throw new \InvalidArgumentException('Volume not supported');
        }

        return $value;
    }

    /**
     * Convert speed.
     *
     * @param float  $value Value to convert
     * @param string $from  Input weight
     * @param string $to    Output weight
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function convertSpeed(float $value, string $from = SpeedType::KILOMETERS_PER_HOUR, string $to = SpeedType::KILOMETERS_PER_HOUR) : float
    {
        // to kph
        $value = self::normalizeSpeed($value, $from);

        switch ($to) {
            case SpeedType::KILOMETERS_PER_HOUR:
                break;
            case SpeedType::MILES_PER_DAY:
                $value = $value * 24 / 1.60934;
                break;
            case SpeedType::MILES_PER_HOUR:
                $value /= 1.60934;
                break;
            case SpeedType::MILES_PER_MINUTE:
                $value = $value / 60 / 1.60934;
                break;
            case SpeedType::MILES_PER_SECOND:
                $value = $value / 3600 / 1.60934;
                break;
            case SpeedType::KILOMETERS_PER_DAY:
                $value *= 24;
                break;
            case SpeedType::KILOMETERS_PER_MINUTE:
                $value /= 60;
                break;
            case SpeedType::KILOMETERS_PER_SECOND:
                $value /= 3600;
                break;
            case SpeedType::METERS_PER_DAY:
                $value = $value * 24 * 1000;
                break;
            case SpeedType::METERS_PER_HOUR:
                $value *= 1000;
                break;
            case SpeedType::METERS_PER_MINUTE:
                $value = $value / 60 * 1000;
                break;
            case SpeedType::METERS_PER_SECOND:
                $value = $value / 3600 * 1000;
                break;
            case SpeedType::CENTIMETERS_PER_DAY:
                $value = $value * 24 * 100000;
                break;
            case SpeedType::CENTIMETERS_PER_HOUR:
                $value *= 100000;
                break;
            case SpeedType::CENTIMETERS_PER_MINUTES:
                $value = $value / 60 * 100000;
                break;
            case SpeedType::CENTIMETERS_PER_SECOND:
                $value = $value / 3600 * 100000;
                break;
            case SpeedType::MILLIMETERS_PER_DAY:
                $value = $value * 24 * 1000000;
                break;
            case SpeedType::MILLIMETERS_PER_HOUR:
                $value *= 1000000;
                break;
            case SpeedType::MILLIMETERS_PER_MINUTE:
                $value = $value / 60 * 1000000;
                break;
            case SpeedType::MILLIMETERS_PER_SECOND:
                $value = $value / 3600 * 1000000;
                break;
            case SpeedType::YARDS_PER_DAY:
                $value = $value * 24 / 0.0009144;
                break;
            case SpeedType::YARDS_PER_HOUR:
                $value /= 0.0009144;
                break;
            case SpeedType::YARDS_PER_MINUTE:
                $value = $value / 60 / 0.0009144;
                break;
            case SpeedType::YARDS_PER_SECOND:
                $value = $value / 3600 / 0.0009144;
                break;
            case SpeedType::INCHES_PER_DAY:
                $value = $value * 24 / 0.0000254;
                break;
            case SpeedType::INCHES_PER_HOUR:
                $value /= 0.0000254;
                break;
            case SpeedType::INCHES_PER_MINUTE:
                $value = $value / 60 / 0.0000254;
                break;
            case SpeedType::INCHES_PER_SECOND:
                $value = $value / 3600 / 0.0000254;
                break;
            case SpeedType::FEET_PER_DAY:
                $value = $value * 24 / 0.0003048;
                break;
            case SpeedType::FEET_PER_HOUR:
                $value /= 0.0003048;
                break;
            case SpeedType::FEET_PER_MINUTE:
                $value = $value / 60 / 0.0003048;
                break;
            case SpeedType::FEET_PER_SECOND:
                $value = $value / 3600 / 0.0003048;
                break;
            case SpeedType::MACH:
                $value /= 1225.044;
                break;
            case SpeedType::KNOTS:
                $value /= 1.852;
                break;
            default:
                throw new \InvalidArgumentException('Speed not supported');
        }

        return $value;
    }

    /**
     * Convert speed.
     *
     * @param float  $value Value to convert
     * @param string $from  Input weight
     *
     * @return float
     *
     * @since  1.0.0
     */
    private static function normalizeSpeed(float $value, string $from) : float
    {
        switch ($from) {
            case SpeedType::KILOMETERS_PER_HOUR:
                break;
            case SpeedType::MILES_PER_DAY:
                $value = $value / 24 * 1.60934;
                break;
            case SpeedType::MILES_PER_HOUR:
                $value *= 1.60934;
                break;
            case SpeedType::MILES_PER_MINUTE:
                $value *= 60 * 1.60934;
                break;
            case SpeedType::MILES_PER_SECOND:
                $value *= 60 * 60 * 1.60934;
                break;
            case SpeedType::KILOMETERS_PER_DAY:
                $value /= 24;
                break;
            case SpeedType::KILOMETERS_PER_MINUTE:
                $value *= 60;
                break;
            case SpeedType::KILOMETERS_PER_SECOND:
                $value *= 60 * 60;
                break;
            case SpeedType::METERS_PER_DAY:
                $value = $value / 24 / 1000;
                break;
            case SpeedType::METERS_PER_HOUR:
                $value /= 1000;
                break;
            case SpeedType::METERS_PER_MINUTE:
                $value *= 60 / 1000;
                break;
            case SpeedType::METERS_PER_SECOND:
                $value *= 60 * 60 / 1000;
                break;
            case SpeedType::CENTIMETERS_PER_DAY:
                $value = $value / 24 / 100000;
                break;
            case SpeedType::CENTIMETERS_PER_HOUR:
                $value /= 100000;
                break;
            case SpeedType::CENTIMETERS_PER_MINUTES:
                $value *= 60 / 100000;
                break;
            case SpeedType::CENTIMETERS_PER_SECOND:
                $value *= 60 * 60 / 100000;
                break;
            case SpeedType::MILLIMETERS_PER_DAY:
                $value = $value / 24 / 1000000;
                break;
            case SpeedType::MILLIMETERS_PER_HOUR:
                $value /= 1000000;
                break;
            case SpeedType::MILLIMETERS_PER_MINUTE:
                $value *= 60 / 1000000;
                break;
            case SpeedType::MILLIMETERS_PER_SECOND:
                $value *= 60 * 60 / 1000000;
                break;
            case SpeedType::YARDS_PER_DAY:
                $value = $value / 24 * 0.0009144;
                break;
            case SpeedType::YARDS_PER_HOUR:
                $value *= 0.0009144;
                break;
            case SpeedType::YARDS_PER_MINUTE:
                $value *= 60 * 0.0009144;
                break;
            case SpeedType::YARDS_PER_SECOND:
                $value *= 60 * 60 * 0.0009144;
                break;
            case SpeedType::INCHES_PER_DAY:
                $value = $value / 24 * 0.0000254;
                break;
            case SpeedType::INCHES_PER_HOUR:
                $value *= 0.0000254;
                break;
            case SpeedType::INCHES_PER_MINUTE:
                $value *= 60 * 0.0000254;
                break;
            case SpeedType::INCHES_PER_SECOND:
                $value *= 60 * 60 * 0.0000254;
                break;
            case SpeedType::FEET_PER_DAY:
                $value = $value / 24 * 0.0003048;
                break;
            case SpeedType::FEET_PER_HOUR:
                $value *= 0.0003048;
                break;
            case SpeedType::FEET_PER_MINUTE:
                $value *= 60 * 0.0003048;
                break;
            case SpeedType::FEET_PER_SECOND:
                $value *= 60 * 60 * 0.0003048;
                break;
            case SpeedType::MACH:
                $value *= 1225.044;
                break;
            case SpeedType::KNOTS:
                $value *= 1.852;
                break;
            default:
                throw new \InvalidArgumentException('Speed not supported');
        }

        return $value;
    }

    /**
     * Convert speed.
     *
     * @param float  $value Value to convert
     * @param string $from  Input weight
     * @param string $to    Output weight
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function convertTime(float $value, string $from = TimeType::SECONDS, string $to = TimeType::HOURS) : float
    {
        // to seconds
        $value = self::normalizeTime($value, $from);

        switch ($to) {
            case TimeType::SECONDS:
                break;
            case TimeType::MINUTES:
                $value /= 60;
                break;
            case TimeType::MILLISECONDS:
                $value *= 1000;
                break;
            case TimeType::HOURS:
                $value *= 3600;
                break;
            case TimeType::DAYS:
                $value *= 3600 * 24;
                break;
            case TimeType::WEEKS:
                $value *= 3600 * 24 * 7;
                break;
            case TimeType::MONTH:
                $value *= 3600 * 24 * 30;
                break;
            case TimeType::QUARTER:
                $value *= 3600 * 24 * 90;
                break;
            case TimeType::YEAR:
                $value *= 3600 * 24 * 365;
                break;
            default:
                throw new \InvalidArgumentException('Size not supported');
        }

        return $value;
    }

    /**
     * Convert speed.
     *
     * @param float  $value Value to convert
     * @param string $from  Input weight
     *
     * @return float
     *
     * @since  1.0.0
     */
    private static function normalizeTime(float $value, string $from) : float
    {
        switch ($from) {
            case TimeType::SECONDS:
                break;
            case TimeType::MINUTES:
                $value *= 60;
                break;
            case TimeType::MILLISECONDS:
                $value /= 1000;
                break;
            case TimeType::HOURS:
                $value /= 3600;
                break;
            case TimeType::DAYS:
                $value /= 3600 * 24;
                break;
            case TimeType::WEEKS:
                $value /= 3600 * 24 * 7;
                break;
            case TimeType::MONTH:
                $value /= 3600 * 24 * 30;
                break;
            case TimeType::QUARTER:
                $value /= 3600 * 24 * 90;
                break;
            case TimeType::YEAR:
                $value /= 3600 * 24 * 365;
                break;
            default:
                throw new \InvalidArgumentException('Size not supported');
        }

        return $value;
    }

    /**
     * Convert speed.
     *
     * @param float  $value Value to convert
     * @param string $from  Input weight
     * @param string $to    Output weight
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function convertAngle(float $value, string $from = AngleType::DEGREE, string $to = AngleType::DEGREE) : float
    {
        // to degree
        $value = self::normalizeAngle($value, $from);

        switch ($to) {
            case AngleType::DEGREE:
                break;
            case AngleType::RADIAN:
                $value /= 57.296;
                break;
            case AngleType::SECOND:
                $value /= 0.00027778;
                break;
            case AngleType::MINUTE:
                $value /= 0.016667;
                break;
            case AngleType::MILLIRADIAN_US:
                $value /= 0.09;
                break;
            case AngleType::MILLIRADIAN_UK:
                $value /= 0.057296;
                break;
            case AngleType::MILLIRADIAN_USSR:
                $value /= 0.057143;
                break;
            case AngleType::MILLIRADIAN_NATO:
                $value /= 0.056250;
                break;
            case AngleType::GRADIAN:
                $value /= 0.09;
                break;
            case AngleType::CENTRAD:
                $value /= 0.57296;
                break;
            default:
                throw new \InvalidArgumentException('Angle not supported');
        }

        return $value;
    }

    /**
     * Convert speed.
     *
     * @param float  $value Value to convert
     * @param string $from  Input weight
     *
     * @return float
     *
     * @since  1.0.0
     */
    private static function normalizeAngle(float $value, string $from) : float
    {
        switch ($from) {
            case AngleType::DEGREE:
                break;
            case AngleType::RADIAN:
                $value *= 57.296;
                break;
            case AngleType::SECOND:
                $value *= 0.00027778;
                break;
            case AngleType::MINUTE:
                $value *= 0.016667;
                break;
            case AngleType::MILLIRADIAN_US:
                $value *= 0.09;
                break;
            case AngleType::MILLIRADIAN_UK:
                $value *= 0.057296;
                break;
            case AngleType::MILLIRADIAN_USSR:
                $value *= 0.057143;
                break;
            case AngleType::MILLIRADIAN_NATO:
                $value *= 0.056250;
                break;
            case AngleType::GRADIAN:
                $value *= 0.09;
                break;
            case AngleType::CENTRAD:
                $value *= 0.57296;
                break;
            default:
                throw new \InvalidArgumentException('Angle not supported');
        }

        return $value;
    }

    /**
     * Convert speed.
     *
     * @param float  $value Value to convert
     * @param string $from  Input weight
     * @param string $to    Output weight
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function convertPressure(float $value, string $from = PressureType::PASCALS, string $to = PressureType::BAR) : float
    {
        // to pascals
        $value = self::normalizePressure($value, $from);

        switch ($to) {
            case PressureType::PASCALS:
                break;
            case PressureType::BAR:
                $value /= 100000;
                break;
            case PressureType::POUND_PER_SQUARE_INCH:
                $value *= 0.00014504;
                break;
            case PressureType::ATMOSPHERES:
                $value /= 101325;
                break;
            case PressureType::INCHES_OF_MERCURY:
                $value *= 0.00029530;
                break;
            case PressureType::INCHES_OF_WATER:
                $value *= 0.0040146;
                break;
            case PressureType::MILLIMETERS_OF_WATER:
                $value *= 0.10197;
                break;
            case PressureType::MILLIMETERS_OF_MERCURY:
                $value *= 0.0075006;
                break;
            case PressureType::MILLIBAR:
                $value /= 100;
                break;
            case PressureType::KILOGRAM_PER_SQUARE_METER:
                $value *= 0.10197;
                break;
            case PressureType::NEWTONS_PER_METER_SQUARED:
                break;
            case PressureType::POUNDS_PER_SQUARE_FOOT:
                $value *= 0.020885;
                break;
            case PressureType::TORRS:
                $value *= 0.0075006;
                break;
            default:
                throw new \InvalidArgumentException('Size not supported');
        }

        return $value;
    }

    /**
     * Convert speed.
     *
     * @param float  $value Value to convert
     * @param string $from  Input weight
     *
     * @return float
     *
     * @since  1.0.0
     */
    private static function normalizePressure(float $value, string $from) : float
    {
        switch ($from) {
            case PressureType::PASCALS:
                break;
            case PressureType::BAR:
                $value *= 100000;
                break;
            case PressureType::POUND_PER_SQUARE_INCH:
                $value /= 0.00014504;
                break;
            case PressureType::ATMOSPHERES:
                $value *= 101325;
                break;
            case PressureType::INCHES_OF_MERCURY:
                $value /= 0.00029530;
                break;
            case PressureType::INCHES_OF_WATER:
                $value /= 0.0040146;
                break;
            case PressureType::MILLIMETERS_OF_WATER:
                $value /= 0.10197;
                break;
            case PressureType::MILLIMETERS_OF_MERCURY:
                $value /= 0.0075006;
                break;
            case PressureType::MILLIBAR:
                $value *= 100;
                break;
            case PressureType::KILOGRAM_PER_SQUARE_METER:
                $value /= 0.10197;
                break;
            case PressureType::NEWTONS_PER_METER_SQUARED:
                break;
            case PressureType::POUNDS_PER_SQUARE_FOOT:
                $value /= 0.020885;
                break;
            case PressureType::TORRS:
                $value /= 0.0075006;
                break;
            default:
                throw new \InvalidArgumentException('Size not supported');
        }

        return $value;
    }

    /**
     * Convert speed.
     *
     * @param float  $value Value to convert
     * @param string $from  Input weight
     * @param string $to    Output weight
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function convertEnergy(float $value, string $from = EnergyPowerType::JOULS, string $to = EnergyPowerType::KILOWATT_HOUERS) : float
    {
        $value = self::normalizeEnergy($value, $from);

        switch ($to) {
            case EnergyPowerType::JOULS:
                break;
            case EnergyPowerType::KILOWATT_HOUERS:
                $value *= 0.00000027778;
                break;
            case EnergyPowerType::MEGAWATT_HOUERS:
                $value *= 0.00000000027778;
                break;
            case EnergyPowerType::KILOTONS:
                $value *= 0.00000000000023901;
                break;
            case EnergyPowerType::CALORIES:
                $value *= 0.00023885;
                break;
            case EnergyPowerType::BTU:
                $value *= 0.00094782;
                break;
            case EnergyPowerType::KILOJOULS:
                $value *= 0.0010000;
                break;
            case EnergyPowerType::THERMEC:
                $value *= 0.0000000094782;
                break;
            case EnergyPowerType::NEWTON_METERS:
                break;
            default:
                throw new \InvalidArgumentException('Energy not supported');
        }

        return $value;
    }

    /**
     * Convert speed.
     *
     * @param float  $value Value to convert
     * @param string $from  Input weight
     *
     * @return float
     *
     * @since  1.0.0
     */
    private static function normalizeEnergy(float $value, string $from) : float
    {
        switch ($from) {
            case EnergyPowerType::JOULS:
                break;
            case EnergyPowerType::KILOWATT_HOUERS:
                $value /= 0.00000027778;
                break;
            case EnergyPowerType::MEGAWATT_HOUERS:
                $value /= 0.00000000027778;
                break;
            case EnergyPowerType::KILOTONS:
                $value /= 0.00000000000023901;
                break;
            case EnergyPowerType::CALORIES:
                $value /= 0.00023885;
                break;
            case EnergyPowerType::BTU:
                $value /= 0.00094782;
                break;
            case EnergyPowerType::KILOJOULS:
                $value /= 0.0010000;
                break;
            case EnergyPowerType::THERMEC:
                $value /= 0.0000000094782;
                break;
            case EnergyPowerType::NEWTON_METERS:
                break;
            default:
                throw new \InvalidArgumentException('Energy not supported');
        }

        return $value;
    }

    /**
     * File size.
     *
     * @param float  $value Value to convert
     * @param string $from  Input weight
     * @param string $to    Output weight
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function convertFileSize(float $value, string $from = FileSizeType::BYTE, string $to = FileSizeType::MEGABYTE) : float
    {
        // to byte
        $value = self::normalizeFileSize($value, $from);

        switch ($to) {
            case FileSizeType::BYTE:
                break;
            case FileSizeType::KILOBYTE:
                $value /= 1000;
                break;
            case FileSizeType::MEGABYTE:
                $value /= 1000000;
                break;
            case FileSizeType::GIGABYTE:
                $value /= 1000000000;
                break;
            case FileSizeType::TERRABYTE:
                $value /= 1000000000000;
                break;
            case FileSizeType::BIT:
                $value *= 8;
                break;
            case FileSizeType::KILOBIT:
                $value *= 0.008;
                break;
            case FileSizeType::MEGABIT:
                $value *= 0.000008;
                break;
            case FileSizeType::GIGABIT:
                $value *= 8e-9;
                break;
            case FileSizeType::TERRABIT:
                $value *= 8e-12;
                break;
            default:
                throw new \InvalidArgumentException('Size not supported');
        }

        return $value;
    }

    /**
     * File size.
     *
     * @param float  $value Value to convert
     * @param string $from  Input weight
     *
     * @return float
     *
     * @since  1.0.0
     */
    private static function normalizeFileSize(float $value, string $from) : float
    {
        switch ($from) {
            case FileSizeType::BYTE:
                break;
            case FileSizeType::KILOBYTE:
                $value *= 1000;
                break;
            case FileSizeType::MEGABYTE:
                $value *= 1000000;
                break;
            case FileSizeType::GIGABYTE:
                $value *= 1000000000;
                break;
            case FileSizeType::TERRABYTE:
                $value *= 1000000000000;
                break;
            case FileSizeType::BIT:
                $value /= 8;
                break;
            case FileSizeType::KILOBIT:
                $value /= 0.008;
                break;
            case FileSizeType::MEGABIT:
                $value /= 0.000008;
                break;
            case FileSizeType::GIGABIT:
                $value /= 8e-9;
                break;
            case FileSizeType::TERRABIT:
                $value /= 8e-12;
                break;
            default:
                throw new \InvalidArgumentException('Size not supported');
        }

        return $value;
    }
}
