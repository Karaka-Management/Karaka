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

namespace phpOMS\DataStorage\Database\Query\Grammar;

use phpOMS\DataStorage\Database\BuilderAbstract;
use phpOMS\DataStorage\Database\GrammarAbstract;
use phpOMS\DataStorage\Database\Query\Builder;
use phpOMS\DataStorage\Database\Query\Column;
use phpOMS\DataStorage\Database\Query\QueryType;
use phpOMS\DataStorage\Database\Query\Where;

/**
 * Database query grammar.
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://orange-management.com
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
        'aggregate',
        'selects',
        'from',
        'joins',
        'wheres',
        'havings',
        'groups',
        'orders',
        'limit',
        'offset',
        'unions',
        'lock',
    ];

    /**
     * Insert components.
     *
     * @var string[]
     * @since 1.0.0
     */
    protected $insertComponents = [
        'into',
        'inserts',
        'values',
    ];

    /**
     * Update components.
     *
     * @var string[]
     * @since 1.0.0
     */
    protected $updateComponents = [
        'updates',
        'sets',
        'wheres',
    ];

    /**
     * Update components.
     *
     * @var string[]
     * @since 1.0.0
     */
    protected $deleteComponents = [
        'deletes',
        'from',
        'wheres',
    ];

    /**
     * Random components.
     *
     * @var string[]
     * @since 1.0.0
     */
    protected $randomComponents = [
        'random',
    ];

    /**
     * Compile components.
     *
     * @param BuilderAbstract $query Builder
     *
     * @return string[]
     *
     * @throws \InvalidArgumentException
     *
     * @since  1.0.0
     */
    protected function compileComponents(BuilderAbstract $query) : array
    {
        $sql = [];

        switch ($query->getType()) {
            case QueryType::SELECT:
                $components = $this->selectComponents;
                break;
            case QueryType::INSERT:
                $components = $this->insertComponents;
                break;
            case QueryType::UPDATE:
                $components = $this->updateComponents;
                break;
            case QueryType::DELETE:
                $components = $this->deleteComponents;
                break;
            case QueryType::RANDOM:
                $components = $this->selectComponents;
                break;
            case QueryType::RAW:
                return [$query->raw];
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
     * Compile select.
     *
     * @param Builder $query   Builder
     * @param array   $columns Columns
     *
     * @return string
     *
     * @since  1.0.0
     */
    protected function compileSelects(Builder $query, array $columns) : string
    {
        $expression = $this->expressionizeTableColumn($columns, $query->getPrefix());

        if ($expression === '') {
            $expression = '*';
        }

        return ($query->distinct ? 'SELECT DISTINCT ' : 'SELECT ') . $expression;
    }

    /**
     * Compile select.
     *
     * @param Builder $query   Builder
     * @param array   $columns Columns
     *
     * @return string
     *
     * @since  1.0.0
     */
    protected function compileUpdates(Builder $query, array $table) : string
    {
        $expression = $this->expressionizeTable($table, $query->getPrefix());
        
        if ($expression === '') {
            return '';
        }

        return 'UPDATE ' . $expression;
    }

    /**
     * Compile select.
     *
     * @param Builder $query   Builder
     * @param array   $columns Columns
     *
     * @return string
     *
     * @since  1.0.0
     */
    protected function compileDeletes(Builder $query, array $columns) : string
    {
        return 'DELETE';
    }

    /**
     * Compile from.
     *
     * @param Builder $query Builder
     * @param array   $table Tables
     *
     * @return string
     *
     * @since  1.0.0
     */
    protected function compileFrom(Builder $query, array $table) : string
    {
        $expression = $this->expressionizeTable($table, $query->getPrefix());

        if ($expression === '') {
            return '';
        }

        return 'FROM ' . $expression;
    }

    /**
     * Compile where.
     *
     * @param Builder $query  Builder
     * @param array   $wheres Where elmenets
     * @param bool    $first  Is first element (usefull for nesting)
     *
     * @return string
     *
     * @since  1.0.0
     */
    protected function compileWheres(Builder $query, array $wheres, bool $first = true) : string
    {
        $expression = '';

        foreach ($wheres as $key => $where) {
            foreach ($where as $key2 => $element) {
                $expression .= $this->compileWhereElement($element, $query, $first);
                $first = false;
            }
        }

        if ($expression === '') {
            return '';
        }

        return 'WHERE ' . $expression;
    }

    /**
     * Compile where element.
     *
     * @param array $element Element data
     * @param Builder $query Query builder
     * @param bool    $first  Is first element (usefull for nesting)
     *
     * @return string
     *
     * @since  1.0.0
     */
    protected function compileWhereElement(array $element, Builder $query, bool $first = true) : string
    {
        $expression = '';

        if (!$first) {
            $expression = ' ' . strtoupper($element['boolean']) . ' ';
        }

        if (is_string($element['column'])) {
            $expression .= $this->compileSystem($element['column'], $query->getPrefix());
        } elseif ($element['column'] instanceof \Closure) {
            $expression .= $element['column']();
        } elseif ($element['column'] instanceof Builder) {
            $expression .= '(' . $element['column']->toSql() . ')';
        } elseif ($element['column'] instanceof Where) {
            $expression .= '(' . $this->compileWhere($element['column'], $query->getPrefix()) . ')';
        }

        // todo: handle IN(...) as operator

        if (isset($element['value'])) {
            $expression .= ' ' . strtoupper($element['operator']) . ' ' . $this->compileValue($element['value'], $query->getPrefix());
        } else {
            $operator = strtoupper($element['operator']) === '=' ? 'IS' : 'IS NOT';
            $expression .= ' ' . $operator . ' ' . $this->compileValue($element['value'], $query->getPrefix());
        }

        return $expression;
    }

    protected function compileWhere(Where $where, string $prefix = '', bool $first = true) : string
    {

        return '';
    }

    /**
     * Compile value.
     *
     * @param array|string|\Closure $value  Value
     * @param string                $prefix Prefix in case value is a table
     *
     * @return string Returns a string representation of the value.
     *
     * @throws \InvalidArgumentException Throws this exception if the value to compile is not supported by this function.
     *
     * @since  1.0.0
     */
    protected function compileValue($value, $prefix = '') : string
    {
        if (is_string($value)) {
            if (strpos($value, ':') === 0) {
                return $value;
            }

            return $this->valueQuotes . $value . $this->valueQuotes;
        } elseif (is_int($value)) {
            return (string) $value;
        } elseif (is_array($value)) {
            $values = '';

            foreach ($value as $val) {
                $values .= $this->compileValue($val) . ', ';
            }

            return '(' . rtrim($values, ', ') . ')';
        } elseif ($value instanceof \DateTime) {
            return $this->valueQuotes . $value->format('Y-m-d H:i:s') . $this->valueQuotes;
        } elseif (is_null($value)) {
            return 'NULL';
        } elseif (is_bool($value)) {
            return (string) ((int) $value);
        } elseif (is_float($value)) {
            return (string) $value;
        } elseif ($value instanceof Column) {
            return $this->compileSystem($value->getColumn(), $prefix);
        } else {
            throw new \InvalidArgumentException(gettype($value));
        }
    }

    /**
     * Compile limit.
     *
     * @param Builder $query Builder
     * @param int     $limit Limit
     *
     * @return string
     *
     * @since  1.0.0
     */
    protected function compileLimit(Builder $query, int $limit) : string
    {
        return 'LIMIT ' . $limit;
    }

    /**
     * Compile offset.
     *
     * @param Builder $query  Builder
     * @param int     $offset Offset
     *
     * @return string
     *
     * @since  1.0.0
     */
    protected function compileOffset(Builder $query, $offset) : string
    {
        return 'OFFSET ' . $offset;
    }

    private function compileJoins()
    {
        return '';
    }

    /**
     * Compile offset.
     *
     * @param Builder $query  Builder
     * @param array   $groups Groups
     *
     * @return string
     *
     * @since  1.0.0
     */
    private function compileGroups(Builder $query, array $groups)
    {
        $expression = '';

        foreach ($groups as $group) {
            $expression .= $this->compileSystem($group, $query->getPrefix()) . ', ';
        }

        $expression = rtrim($expression, ', ');

        return 'GROUP BY ' . $expression;
    }

    /**
     * Compile offset.
     *
     * @param Builder $query  Builder
     * @param array   $orders Order
     *
     * @return string
     *
     * @since  1.0.0
     */
    private function compileOrders(Builder $query, array $orders) : string
    {
        $expression = '';

        foreach ($orders as $key => $order) {
            foreach ($order as $column) {
                $expression .= $this->compileSystem($column, $query->getPrefix()) . ', ';
            }

            $expression = rtrim($expression, ', ');
            $expression .= ' ' . $key . ', ';
        }

        if ($expression === '') {
            return '';
        }

        $expression = rtrim($expression, ', ');

        return 'ORDER BY ' . $expression;
    }

    private function compileUnions()
    {
        return '';
    }

    private function compileLock()
    {
        return '';
    }

    /**
     * Compile insert into table.
     *
     * @param Builder $query Builder
     * @param string  $table Table
     *
     * @return string
     *
     * @since  1.0.0
     */
    protected function compileInto(Builder $query, $table) : string
    {
        return 'INSERT INTO ' . $this->compileSystem($table, $query->getPrefix());
    }

    /**
     * Compile insert into columns.
     *
     * @param Builder $query   Builder
     * @param array   $columns Columns
     *
     * @return string
     *
     * @since  1.0.0
     */
    protected function compileInserts(Builder $query, array $columns) : string
    {
        $cols = '';

        foreach ($columns as $column) {
            $cols .= $this->compileSystem($column) . ', ';
        }

        if ($cols === '') {
            return '';
        }

        return '(' . rtrim($cols, ', ') . ')';
    }

    /**
     * Compile insert values.
     *
     * @param Builder $query  Builder
     * @param array   $values Values
     *
     * @return string
     *
     * @since  1.0.0
     */
    protected function compileValues(Builder $query, array $values) : string
    {
        $vals = '';

        foreach ($values as $value) {
            $vals .= $this->compileValue($value) . ', ';
        }

        if ($vals === '') {
            return '';
        }

        return 'VALUES ' . rtrim($vals, ', ');
    }

    /**
     * Compile insert values.
     *
     * @param Builder $query  Builder
     * @param array   $values Values
     *
     * @return string
     *
     * @since  1.0.0
     */
    protected function compileSets(Builder $query, array $values) : string
    {
        $vals = '';

        foreach ($values as $column => $value) {
            // todo change expressionizeTableColumn to accept single column and create additionl for Columns
            $expression = $this->expressionizeTableColumn([$column], $query->getPrefix());

            $vals .= $expression . ' = ' . $this->compileValue($value) . ', ';
        }

        if ($vals === '') {
            return '';
        }

        return 'SET ' . rtrim($vals, ', ');
    }
}
