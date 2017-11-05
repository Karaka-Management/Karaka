<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   Framework
 * @package    phpOMS\Localization
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
declare(strict_types = 1);

namespace phpOMS\Localization;

/**
 * Money class.
 *
 * @category   Framework
 * @package    phpOMS\Localization
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Money implements \Serializable
{

    /**
     * Max amount of decimals.
     *
     * @var int
     * @since 1.0.0
     */
    /* public */ const MAX_DECIMALS = 4;

    /**
     * Thousands separator.
     *
     * @var string
     * @since 1.0.0
     */
    private $thousands = ',';

    /**
     * Decimal separator.
     *
     * @var string
     * @since 1.0.0
     */
    private $decimal = '.';

    /**
     * Currency symbol position
     *
     * @var int
     * @since 1.0.0
     */
    private $position = 1;

    /**
     * Currency symbol.
     *
     * @var string
     * @since 1.0.0
     */
    private $symbol = ISO4217SymbolEnum::_USD;

    /**
     * Value.
     *
     * @var int
     * @since 1.0.0
     */
    private $value = 0;

    /**
     * Constructor.
     *
     * @param string|int|float $value     Value
     * @param string           $thousands Thousands separator
     * @param string           $decimal   Decimal separator
     * @param string           $symbol    Currency symbol
     * @param int              $position  Symbol position
     *
     * @since  1.0.0
     */
    public function __construct($value = 0, string $thousands = ',', string $decimal = '.', string $symbol = '', int $position = 0)
    {
        $this->value     = is_int($value) ? $value : self::toInt((string) $value);
        $this->thousands = $thousands;
        $this->decimal   = $decimal;
        $this->symbol    = $symbol;
        $this->position  = $position;
    }

    /**
     * Money to int.
     *
     * @param string $value     Money value
     * @param string $thousands Thousands character
     * @param string $decimal   Decimal character
     *
     * @return int
     *
     * @since  1.0.0
     */
    public static function toInt(string $value, string $thousands = ',', string $decimal = '.')  : int
    {
        $split = explode($decimal, $value);
        $left  = $split[0];
        $left  = str_replace($thousands, '', $left);
        $right = '';

        if (count($split) > 1) {
            $right = $split[1];
        }

        $right = substr($right, 0, self::MAX_DECIMALS);

        return (int) (((int) $left) * 10 ** self::MAX_DECIMALS + (int) str_pad($right, self::MAX_DECIMALS, '0'));
    }

    /**
     * Set localization.
     *
     * @param string $thousands Thousands separator
     * @param string $decimal   Decimal separator
     * @param string $symbol    Currency symbol
     * @param int    $position  Symbol position
     *
     * @return Money
     *
     * @since  1.0.0
     */
    public function setLocalization(string $thousands = ',', string $decimal = '.', string $symbol = '', int $position = 0) /* : void */
    {
        $this->thousands = $thousands;
        $this->decimal   = $decimal;
        $this->symbol    = $symbol;
        $this->position  = $position;

        return $this;
    }

    /**
     * Set value by string.
     *
     * @param string $value Money value
     *
     * @return Money
     *
     * @since  1.0.0
     */
    public function setString(string $value) : Money
    {
        $this->value = self::toInt($value, $this->thousands, $this->decimal);

        return $this;
    }

    /**
     * Get money.
     *
     * @param int $decimals Precision
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getCurrency(int $decimals = 2) : string
    {
        return ($this->position === 0 ? $this->symbol : '') . $this->getAmount($decimals) . ($this->position === 1 ? $this->symbol : '');
    }

    /**
     * Get money.
     *
     * @param int $decimals Precision
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getAmount(int $decimals = 2) : string
    {
        $value = (string) round($this->value, -self::MAX_DECIMALS + $decimals);

        $left  = substr($value, 0, -self::MAX_DECIMALS);
        $right = substr($value, -self::MAX_DECIMALS);

        return ($decimals > 0) ? number_format((float) $left, 0, $this->decimal, $this->thousands) . $this->decimal . substr($right, 0, $decimals) : (string) $left;
    }

    /**
     * Add money.
     *
     * @param Money|string|int|float $value
     *
     * @return Money
     *
     * @since  1.0.0
     */
    public function add($value) : Money
    {
        if (is_string($value) || is_float($value)) {
            $this->value += self::toInt((string) $value, $this->thousands, $this->decimal);
        } elseif (is_int($value)) {
            $this->value += $value;
        } elseif ($value instanceof Money) {
            $this->value += $value->getInt();
        } 

        return $this;
    }

    /**
     * Get money value.
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function getInt() : int
    {
        return $this->value;
    }

    /**
     * Sub money.
     *
     * @param Money|string|int|float $value
     *
     * @return Money
     *
     * @since  1.0.0
     */
    public function sub($value) : Money
    {
        if (is_string($value) || is_float($value)) {
            $this->value -= self::toInt((string) $value, $this->thousands, $this->decimal);
        } elseif (is_int($value)) {
            $this->value -= $value;
        } elseif ($value instanceof Money) {
            $this->value -= $value->getInt();
        } 

        return $this;
    }

    /**
     * Mult.
     *
     * @param int|float $value
     *
     * @return Money
     *
     * @since  1.0.0
     */
    public function mult($value) : Money
    {
        if (is_float($value) || is_int($value)) {
            $this->value = (int) ($this->value * $value);
        }

        return $this;
    }

    /**
     * Div.
     *
     * @param int|float $value
     *
     * @return Money
     *
     * @since  1.0.0
     */
    public function div($value) : Money
    {
        if (is_float($value) || is_int($value)) {
            $this->value = (int) ($this->value / $value);
        }

        return $this;
    }

    /**
     * Abs.
     *
     * @return Money
     *
     * @since  1.0.0
     */
    public function abs() : Money
    {
        $this->value = abs($this->value);

        return $this;
    }

    /**
     * Power.
     *
     * @param int|float $value
     *
     * @return Money
     *
     * @since  1.0.0
     */
    public function pow($value) : Money
    {
        if (is_float($value) || is_int($value)) {
            $this->value = $this->value ** $value;
        }

        return $this;
    }

    /**
     * Searialze.
     *
     * @return int
     *
     * @since  1.0.0
     */
    public function serialize()
    {
        return $this->getInt();
    }

    /**
     * Unserialize.
     *
     * @param mixed $value
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function unserialize($value)
    {
        $this->setInt($value);
    }

    /**
     * Set money value.
     *
     * @param int $value Value
     *
     * @return Money
     *
     * @since  1.0.0
     */
    public function setInt(int $value) : Money
    {
        $this->value = $value;

        return $this;
    }
}
