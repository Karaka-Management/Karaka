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

namespace phpOMS\Utils\EDI\AnsiX12;

/**
 * EDI Header
 *
 * @category   Framework
 * @package    phpOMS\Utils\Converter
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Header
{
    private $interchangeControlHeader = null;

    private $functionalGroupHeader = null;

    public function __construct() 
    {
        $this->interchangeControlHeader = new InterchangeControlHeader();
        $this->functionalGroupHeader = new FunctionalGroupHeader();
    }
}
