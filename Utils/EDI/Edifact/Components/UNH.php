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

namespace phpOMS\Utils\EDI\Edifact\Components;

/**
 * EDI Header
 *
 * @category   Framework
 * @package    phpOMS\Utils\Converter
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class UNH
{
    private $ref = '';

    private $type = '';

    private $version = 'D';

    private $subersion = '06A';

    private $un = 'UN';

    private $bdewVersion = '2.6d';

    public function __construct(string $ref, string $type, string $version, string $subersion, string $un, string $bdewVersion)
    {
        $this->ref = $ref;
        $this->type = $type;
        $this->version = $version;
        $this->subersion = $subersion;
        $this->un = $un;
        $this->bdewVersion = $bdewVersion;
    }
}
