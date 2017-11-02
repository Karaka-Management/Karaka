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

namespace phpOMS\Validation\Finance;

use phpOMS\Stdlib\Base\Enum;

/**
 * Iban layout definition.
 *
 * @category   Framework
 * @package    phpOMS\Localization
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class IbanEnum extends Enum
{
    /* public */ const C_AL = 'ALkk bbbs sssx cccc cccc cccc cccc';
    /* public */ const C_AD = 'ADkk bbbb ssss cccc cccc cccc';
    /* public */ const C_AT = 'ATkk bbbb bccc cccc cccc';
    /* public */ const C_AZ = 'AZkk bbbb cccc cccc cccc cccc cccc ';
    /* public */ const C_BH = 'BHkk bbbb cccc cccc cccc cc';
    /* public */ const C_BE = 'BEkk bbbc cccc ccxx';
    /* public */ const C_BA = 'BAkk bbbs sscc cccc ccxx';
    /* public */ const C_BR = 'BRkk bbbb bbbb ssss sccc cccc ccct n';
    /* public */ const C_BG = 'BGkk bbbb ssss ttcc cccc cc';
    /* public */ const C_CR = 'CRkk bbbc cccc cccc cccc c';
    /* public */ const C_HR = 'HRkk bbbb bbbc cccc cccc c';
    /* public */ const C_CY = 'CYkk bbbs ssss cccc cccc cccc cccc';
    /* public */ const C_CZ = 'CZkk bbbb ssss sscc cccc cccc';
    /* public */ const C_DK = 'DKkk bbbb cccc cccc cc';
    /* public */ const C_DO = 'DOkk bbbb cccc cccc cccc cccc cccc';
    /* public */ const C_TL = 'TLkk bbbc cccc cccc cccc cxx';
    /* public */ const C_EE = 'EEkk bbss cccc cccc cccx';
    /* public */ const C_FO = 'FOkk bbbb cccc cccc cx';
    /* public */ const C_FI = 'FIkk bbbb bbcc cccc cx';
    /* public */ const C_FR = 'FRkk bbbb bsss sscc cccc cccc cxx';
    /* public */ const C_GE = 'GEkk bbcc cccc cccc cccc cc';
    /* public */ const C_DE = 'DEkk bbbb bbbb cccc cccc cc';
    /* public */ const C_GI = 'GIkk bbbb cccc cccc cccc ccc';
    /* public */ const C_GR = 'GRkk bbbs sssc cccc cccc cccc ccc';
    /* public */ const C_GL = 'GLkk bbbb cccc cccc cc';
    /* public */ const C_GT = 'GTkk bbbb mmtt cccc cccc cccc cccc';
    /* public */ const C_HU = 'HUkk bbbs sssx cccc cccc cccc cccx';
    /* public */ const C_IS = 'ISkk bbbb sscc cccc iiii iiii ii';
    /* public */ const C_IE = 'IEkk aaaa bbbb bbcc cccc cc';
    /* public */ const C_IL = 'ILkk bbbn nncc cccc cccc ccc';
    /* public */ const C_IT = 'ITkk xbbb bbss sssc cccc cccc ccc';
    /* public */ const C_JO = 'JOkk bbbb ssss cccc cccc cccc cccc cc';
    /* public */ const C_KZ = 'KZkk bbbc cccc cccc cccc';
    /* public */ const C_XK = 'XKkk bbbb cccc cccc cccc';
    /* public */ const C_KW = 'KWkk bbbb cccc cccc cccc cccc cccc cc';
    /* public */ const C_LV = 'LVkk bbbb cccc cccc cccc c';
    /* public */ const C_LB = 'LBkk bbbb cccc cccc cccc cccc cccc';
    /* public */ const C_LI = 'LIkk bbbb bccc cccc cccc c';
    /* public */ const C_LT = 'LTkk bbbb bccc cccc cccc';
    /* public */ const C_LU = 'LUkk bbbc cccc cccc cccc';
    /* public */ const C_MK = 'MKkk bbbc cccc cccc cxx';
    /* public */ const C_MT = 'MTkk bbbb ssss sccc cccc cccc cccc ccc';
    /* public */ const C_MR = 'MRkk bbbb bsss sscc cccc cccc cxx';
    /* public */ const C_MU = 'MUkk bbbb bbss cccc cccc cccc 000m mm';
    /* public */ const C_MC = 'MCkk bbbb bsss sscc cccc cccc cxx';
    /* public */ const C_MD = 'MDkk bbcc cccc cccc cccc cccc';
    /* public */ const C_ME = 'MEkk bbbc cccc cccc cccc xx';
    /* public */ const C_NL = 'NLkk bbbb cccc cccc cc';
    /* public */ const C_NO = 'NOkk bbbb cccc ccx';
    /* public */ const C_PK = 'PKkk bbbb cccc cccc cccc cccc';
    /* public */ const C_PS = 'PSkk bbbb xxxx xxxx xccc cccc cccc c';
    /* public */ const C_PL = 'PLkk bbbs sssx cccc cccc cccc cccc';
    /* public */ const C_PT = 'PTkk bbbb ssss cccc cccc cccx x';
    /* public */ const C_QA = 'QAkk bbbb cccc cccc cccc cccc cccc c';
    /* public */ const C_RO = 'ROkk bbbb cccc cccc cccc cccc';
    /* public */ const C_SM = 'SMkk xbbb bbss sssc cccc cccc ccc';
    /* public */ const C_SA = 'SAkk bbcc cccc cccc cccc cccc';
    /* public */ const C_RS = 'RSkk bbbc cccc cccc cccc xx';
    /* public */ const C_SK = 'SKkk bbbb ssss sscc cccc cccc';
    /* public */ const C_SI = 'SIkk bbss sccc cccc cxx';
    /* public */ const C_ES = 'ESkk bbbb ssss xxcc cccc cccc';
    /* public */ const C_SE = 'SEkk bbbc cccc cccc cccc cccc';
    /* public */ const C_CH = 'CHkk bbbb bccc cccc cccc c';
    /* public */ const C_TN = 'TNkk bbss sccc cccc cccc cccc';
    /* public */ const C_TR = 'TRkk bbbb bxcc cccc cccc cccc cc';
    /* public */ const C_UA = 'UAkk bbbb bbcc cccc cccc cccc cccc c';
    /* public */ const C_AE = 'AEkk bbbc cccc cccc cccc ccc';
    /* public */ const C_GB = 'GBkk bbbb ssss sscc cccc cc';
    /* public */ const C_VG = 'VGkk bbbb cccc cccc cccc cccc';
    /* public */ const C_SN = 'SNkk annn nnnn nnnn nnnn nnnn nnnn';
    /* public */ const C_MZ = 'MZkk nnnn nnnn nnnn nnnn nnnn n';
    /* public */ const C_ML = 'MLkk annn nnnn nnnn nnnn nnnn nnnn';
    /* public */ const C_MG = 'MGkk nnnn nnnn nnnn nnnn nnnn nnn';
    /* public */ const C_CI = 'CIkk annn nnnn nnnn nnnn nnnn nnnn';
    /* public */ const C_IR = 'IRkk nnnn nnnn nnnn nnnn nnnn nn';
    /* public */ const C_CV = 'CVkk nnnn nnnn nnnn nnnn nnnn n';
    /* public */ const C_CM = 'CMkk nnnn nnnn nnnn nnnn nnnn nnn';
    /* public */ const C_BI = 'BIkk nnnn nnnn nnnn';
    /* public */ const C_BF = 'BFkk nnnn nnnn nnnn nnnn nnnn nnn';
    /* public */ const C_BJ = 'BJkk annn nnnn nnnn nnnn nnnn nnnn';
    /* public */ const C_AO = 'AOkk nnnn nnnn nnnn nnnn nnnn n';
    /* public */ const C_DZ = 'DZkk nnnn nnnn nnnn nnnn nnnn';
}
