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
namespace phpOMS\Utils\Crawler;

use phpOMs\DataStorage\Database\Query\Builder as DatabaseQueryBuilder;

/**
 * Array utils.
 *
 * @category   Framework
 * @package    phpOMS\Utils
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Builder extends DatabaseQueryBuilder
{

    private function download($uri)
    {
        $finder = [];
        $l11n = new Localization();
        
        foreach ($this->from as $from) {
            $doc = new \DOMDocument();
            $doc->loadHTML(Rest::request($l11n, new Http($from)));
            $finder[$from] = new \DomXPath($doc);
        }

        return $finder;
    }
    
    public function get(string $xpath)
    {
        $nodes = $finder->query($xpath);
    }
    
    public function execute()
    {
        $finder = $this->download();
        $result = [];
        $table = null;

        foreach ($this->wheres as $column => $where) {
            if ($column === 'xpath') {
                $table = $this->createTable($finder->query($where['value']));
            }
        }

        foreach ($this->columns as $column) {
        }
    }

    private function createTable($node) : array
    {
        if (strtolower($node->tagName) === 'table') {
            return $this->createTableFromTable();
        } elseif (strtolower($node->tagName) === 'li') {
            return $this->createTableFromList();
        } else {
            return $this->createTableFromContent();
        }
    }

    private function createTableFromTable($node) : array
    {
        // todo: get header either thead or <th> (either first row or first column)

        // todo: get rest except tfoot

        // find first unique column and define as additional id (in addition to row number)
    }

    private function createTableFromList($node) : array
    {
        $table = [];
        $children = $node->childNodes;

        foreach ($children as $child) {
            $table[] = $child->asXML();
        }
        
        return $table;
    }

    private function createTableFromContent($node) : array
    {
        return [$node->asXML()];
    }
}
