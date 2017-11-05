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

use phpOMS\Utils\EDI\AnsiX12\EDIAbstract;
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
class EDI850 extends EDIAbstract
{
    private $interchangeControlHeader = null;

    private $functionalGroupHeader = null;

    private $heading = null;

    private $detail = null;

    private $summary = null;

    private $functionalGroupTrailer = null;

    private $interchangeControlTrailer = null;

    public function __construct()
    {
        $this->interchangeControlHeader = new ISA();
        $this->functionalGroupHeader = new GS();

        $this->heading = new EDI850Heading();
        $this->detail = new EDI850Detail();
        $this->summary = new EDI850Summary();

        $this->functionalGroupTrailer = new GE();
        $this->interchangeControlTrailer = new IEA();
    }
}
