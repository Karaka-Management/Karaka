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

namespace phpOMS\Utils\RnG;


/**
 * Phone generator.
 *
 * @category   Framework
 * @package    Utils\RnG
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Phone
{

    /**
     * Get a random phone number.
     *
     * @param bool  $isInt     This number uses a country code
     * @param array $layout    Number layout
     * @param array $countries Country codes
     *
     * @return \DateTime
     *
     * @since  1.0.0
     */
    public static function generatePhone($isInt = true, $layout = ['struct' => '+$1 ($2) $3-$4',
                                                                   'size'   => [null,
                                                                                [3, 4],
                                                                                [3, 5],
                                                                                [3, 8],],], $countries = null)
    {
        $numberString = $layout['struct'];

        if ($isInt) {
            if ($countries === null) {
                $countries = ['de' => 49, 'us' => 1];
            }

            $numberString = str_replace('$1', $countries[array_keys($countries)[rand(0, count($countries))]], $numberString);
        }

        $numberParts = substr_count($layout['struct'], '$');

        for ($i = ($isInt ? 2 : 1); $i < $numberParts; $i++) {
            $numberString = str_replace('$' . $i, StringUtils::generateString($layout['size'][$i - 1][0], $layout['size'][$i - 1][1], '0123456789'), $numberString);
        }

        return $numberString;
    }
}
