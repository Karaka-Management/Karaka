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
 * Code 128c class.
 *
 * @category   Log
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class C128c extends C128Abstract
{
    /**
     * Checksum.
     *
     * @var int
     * @since 1.0.0
     */
    protected static $CHECKSUM = 105;

    /**
     * Char weighted array.
     *
     * @var string[]
     * @since 1.0.0
     */
    protected static $CODEARRAY = [
        '00'     => '212222', '01' => '222122', '02' => '222221', '03' => '121223', '04' => '121322', '05' => '131222',
        '06'     => '122213', '07' => '122312', '08' => '132212', '09' => '221213', '10' => '221312', '11' => '231212',
        '12'     => '112232', '13' => '122132', '14' => '122231', '15' => '113222', '16' => '123122', '17' => '123221',
        '18'     => '223211', '19' => '221132', '20' => '221231', '21' => '213212', '22' => '223112', '23' => '312131',
        '24'     => '311222', '25' => '321122', '26' => '321221', '27' => '312212', '28' => '322112', '29' => '322211',
        '30'     => '212123', '31' => '212321', '32' => '232121', '33' => '111323', '34' => '131123', '35' => '131321',
        '36'     => '112313', '37' => '132113', '38' => '132311', '39' => '211313', '40' => '231113', '41' => '231311',
        '42'     => '112133', '43' => '112331', '44' => '132131', '45' => '113123', '46' => '113321', '47' => '133121',
        '48'     => '313121', '49' => '211331', '50' => '231131', '51' => '213113', '52' => '213311', '53' => '213131',
        '54'     => '311123', '55' => '311321', '56' => '331121', '57' => '312113', '58' => '312311', '59' => '332111',
        '60'     => '314111', '61' => '221411', '62' => '431111', '63' => '111224', '64' => '111422', '65' => '121124',
        '66'     => '121421', '67' => '141122', '68' => '141221', '69' => '112214', '70' => '112412', '71' => '122114',
        '72'     => '122411', '73' => '142112', '74' => '142211', '75' => '241211', '76' => '221114', '77' => '413111',
        '78'     => '241112', '79' => '134111', '80' => '111242', '81' => '121142', '82' => '121241', '83' => '114212',
        '84'     => '124112', '85' => '124211', '86' => '411212', '87' => '421112', '88' => '421211', '89' => '212141',
        '90'     => '214121', '91' => '412121', '92' => '111143', '93' => '111341', '94' => '131141', '95' => '114113',
        '96'     => '114311', '97' => '411113', '98' => '411311', '99' => '113141', 'CODE B' => '114131',
        'CODE A' => '311141', 'FNC 1' => '411131', 'Start A' => '211412', 'Start B' => '211214', 'Start C' => '211232',
        'Stop'   => '2331112',
    ];

    /**
     * Code start.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $CODE_START = '211232';

    /**
     * Code end.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $CODE_END = '2331112';

    /**
     * Generate weighted code string
     *
     * @return string
     *
     * @since  1.0.0
     */
    protected function generateCodeString() : string
    {
        $keys       = array_keys(self::$CODEARRAY);
        $values     = array_flip($keys);
        $codeString = '';
        $length     = strlen($this->content);
        $checksum   = self::$CHECKSUM;
        $checkPos   = 1;

        for ($pos = 1; $pos <= $length; $pos += 2) {
            if ($pos + 1 <= $length) {
                $activeKey = substr($this->content, ($pos - 1), 2);
            } else {
                $activeKey = substr($this->content, ($pos - 1), 1) . '0';
            }

            $codeString .= self::$CODEARRAY[$activeKey];
            $checksum += $values[$activeKey] * $checkPos;
            $checkPos++;
        }

        $codeString .= self::$CODEARRAY[$keys[($checksum - (intval($checksum / 103) * 103))]];

        return $codeString;
    }
}
