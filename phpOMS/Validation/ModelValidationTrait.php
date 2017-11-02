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

namespace phpOMS\Validation;


/**
 * Model validation trait.
 *
 * @category   Framework
 * @package    phpOMS\Config
 * @since      1.0.0
 */
trait ModelValidationTrait
{

    /** @noinspection PhpUnusedPrivateMethodInspection */
    /**
     * Set variable without validating it.
     *
     * @param mixed  $var  Variable to set
     * @param string $name Name of the variable
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    public function setForce($var, $name) /* : void */
    {
        if (!property_exists($this, $var)) {
            throw new \Exception('Unknown property.');
        }

        $this->{$name} = $var;
    }

    /** @noinspection PhpUnusedPrivateMethodInspection */

    /**
     * Validate member variable.
     *
     * @param mixed  $var  Variable to validate
     * @param string $name Name of the variable
     *
     * @return bool
     *
     * @since  1.0.0
     */
    protected function isValid($var, $name) : bool
    {
        /** @noinspection PhpUndefinedFieldInspection */
        if (!isset(self::${$name . '_validate'})) {
            return true;
        }

        /** @noinspection PhpUndefinedFieldInspection */
        return Validator::isValid($var, self::$validation[$name]);
    }

    /**
     * Set validated member variable.
     *
     * @param mixed  $var  Variable to validate
     * @param string $name Name of the variable
     *
     * @return bool
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    protected function setValidation($var, $name) /* : void */
    {
        /** @noinspection PhpUndefinedFieldInspection */
        if (!isset(self::${$name . '_validate'}) || Validator::isValid($var, self::$validation[$name]) === true) {
            $this->{$name} = $var;
        } else {
            throw new \Exception('Invalid data for variable ' . $name);
        }
    }
}
