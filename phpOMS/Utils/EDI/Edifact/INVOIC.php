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

namespace phpOMS\Utils\EDI\Edifact;

use phpOMS\Utils\EDI\Edifact\Components\UNH;
use phpOMS\Utils\EDI\Edifact\Components\BGM;

/**
 * EDI Header
 *
 * @category   Framework
 * @package    phpOMS\Utils\Converter
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class INVOIC
{
    private $unh = null;

    private $bgm = null;

    public function __construct()
    {
        $this->unh = new UNH('INVOIC', 'D', '06A', 'UN', '2.6d');
        $this->bgm = new BGM();
    }
}
