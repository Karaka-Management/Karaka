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

namespace phpOMS\Utils\EDI\AnsiX12\Purchase\PurchaseOrder;

use phpOMS\Utils\EDI\AnsiX12\Component;

/**
 * EDI 850 - Purchase order.
 *
 * @category   Framework
 * @package    phpOMS\Utils\Converter
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class EDI850Summary
{
    private $summaryTransationTotals = 0;

    private $summaryMonetaryAmount = 0;

    private $summaryTransectionSetTrailer = '';
}
