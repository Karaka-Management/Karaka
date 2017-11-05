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

namespace phpOMS\Utils\IO\Csv;

use phpOMS\DataStorage\Database\Connection\ConnectionAbstract;
use phpOMS\DataStorage\Database\Query\Builder;
use phpOMS\Utils\IO\IODatabaseMapper;

class CsvDatabaseMapper implements IODatabaseMapper
{
    private $db = null;

    private $sources = [];

    private $delimiter = ';';
    private $enclosure = '"';
    private $lineBuffer = 500;

    private $autoIdentifyCsvSettings = false;

    public function __construct(ConnectionAbstract $db)
    {
        $this->db = $db;
    }

    public function addSource(string $source)
    {
        $this->sources[] = $source;

        $this->sources = array_unique($this->sources);
    }

    public function setSources(array $sources) /* : void */
    {
        $this->sources = $sources;
    }

    public function autoIdentifyCsvSettings(bool $identify)
    {
        $this->autoIdentifyCsvSettings = $identify;
    }

    public function setLineBuffer(int $buffer) /* : void */
    {
        $this->lineBuffer = $buffer;
    }

    public function insert()
    {
        foreach ($this->sources as $source) {
            $file      = fopen($source, 'r');
            $header    = [];
            $delimiter = $this->autoIdentifyCsvSettings ? $this->getFileDelimiter($file, 100) : $this->delimiter;

            if (feof($file) && ($line = fgetcsv($file, 0, $delimiter)) !== false) {
                $header = $line;
            }

            $query = new Builder($this->db);
            $query->insert(...$header)->into(str_replace(' ', '', explode($source, '.')));

            while (feof($file)) {
                $c = 0;

                while (($line = fgetcsv($file)) !== false && $c < $this->lineBuffer && feof($file)) {
                    $query->values($line);
                    $c++;
                }

                $this->db->con->prepare($query->toSql())->execute();
            }

            fclose($file);
        }
    }
}
