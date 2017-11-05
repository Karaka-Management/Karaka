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

namespace phpOMS\Utils\IO\Excel;

use phpOMS\Utils\IO\IODatabaseMapper;

class ExcelDatabaseMapper implements IODatabaseMapper
{
    private $sources = [];
    private $lineBuffer = 500;

    public function addSource(string $source)
    {
        $this->sources[] = $source;
    }

    public function setLineBuffer(int $buffer) /* : void */
    {
        $this->lineBuffer = $buffer;
    }

    public function setSources(array $sources) /* : void */
    {
        $this->sources = $sources;
    }

    public function insert()
    {
    }
}

