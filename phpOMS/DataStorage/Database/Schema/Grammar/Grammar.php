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

namespace phpOMS\DataStorage\Database\Schema\Grammar;

use phpOMS\DataStorage\Database\BuilderAbstract;
use phpOMS\DataStorage\Database\GrammarAbstract;
use phpOMS\DataStorage\Database\Schema\QueryType;

/**
 * Database query grammar.
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Grammar extends GrammarAbstract
{
    /**
     * Select components.
     *
     * @var string[]
     * @since 1.0.0
     */
    protected $selectComponents = [
        'selects',
        'from',
    ];

    /**
     * Select components.
     *
     * @var string[]
     * @since 1.0.0
     */
    protected $dropComponents = [
        'drop',
    ];

    /**
     * Compile components based on query type.
     *
     * @param BuilderAbstract $query Query
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function compileComponents(BuilderAbstract $query) : array
    {
        $sql = [];

        switch ($query->getType()) {
            case QueryType::DROP:
                $components = $this->dropComponents;
                break;
            default:
                throw new \InvalidArgumentException('Unknown query type.');
        }

        /* Loop all possible query components and if they exist compile them. */
        foreach ($components as $component) {
            if (isset($query->{$component}) && !empty($query->{$component})) {
                $sql[$component] = $this->{'compile' . ucfirst($component)}($query, $query->{$component});
            }
        }

        return $sql;
    }

    /**
     * Compile drop query.
     *
     * @param BuilderAbstract $query  Query
     * @param array           $tables Tables to drop
     *
     * @return string
     *
     * @since  1.0.0
     */
    protected function compileDrop(BuilderAbstract $query, array $tables) : string
    {
        $expression = $this->expressionizeTableColumn($tables, $query->getPrefix());

        if ($expression === '') {
            $expression = '*';
        }

        return 'DROP TABLE ' . $expression;
    }
}
