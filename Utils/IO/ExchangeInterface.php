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

namespace phpOMS\Utils\IO;

use phpOMS\Utils\IO\Csv\CsvInterface;
use phpOMS\Utils\IO\Excel\ExcelInterface;
use phpOMS\Utils\IO\Json\JsonInterface;
use phpOMS\Utils\IO\Pdf\PdfInterface;

/**
 * Exchange interface.
 *
 * @category   Framework
 * @package    phpOMS\Utils\IO
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
interface ExchangeInterface extends CsvInterface, JsonInterface, ExcelInterface, PdfInterface
{
}
