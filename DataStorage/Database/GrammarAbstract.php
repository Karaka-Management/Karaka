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

namespace phpOMS\DataStorage\Database;

/**
 * Grammar.
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
abstract class GrammarAbstract
{
    /**
     * Comment style.
     *
     * @var string
     * @since 1.0.0
     */
    protected $comment = '--';

    /**
     * String quotes style.
     *
     * @var string
     * @since 1.0.0
     */
    protected $valueQuotes = '\'';

    /**
     * System identifier.
     *
     * @var string
     * @since 1.0.0
     */
    protected $systemIdentifier = '"';

    /**
     * And operator.
     *
     * @var string
     * @since 1.0.0
     */
    protected $and = 'AND';

    /**
     * Or operator.
     *
     * @var string
     * @since 1.0.0
     */
    protected $or = 'OR';

    /**
     * Table prefix.
     *
     * @var string
     * @since 1.0.0
     */
    protected $tablePrefix = '';

    /**
     * Special keywords.
     *
     * @var array
     * @since 1.0.0
     */
    protected $specialKeywords = [
        'COUNT('
    ];

    /**
     * Compile to query.
     *
     * @param BuilderAbstract $query Builder
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function compileQuery(BuilderAbstract $query) : string
    {
        return trim(
            implode(' ',
                array_filter(
                    $this->compileComponents($query),
                    function ($value) {
                        return (string) $value !== '';
                    }
                )
            )
        ) . ';';
    }

    /**
     * Compile query components.
     *
     * @param BuilderAbstract $query Builder
     *
     * @return array Parsed query components
     *
     * @since  1.0.0
     */
    abstract protected function compileComponents(BuilderAbstract $query) : array;

    /**
     * Get date format.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getDateFormat() : string
    {
        return 'Y-m-d H:i:s';
    }

    /**
     * Get table prefix.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function getTablePrefix() : string
    {
        return $this->tablePrefix;
    }

    /**
     * Set table prefix.
     *
     * @param string $prefix Table prefix
     *
     * @since  1.0.0
     */
    public function setTablePrefix(string $prefix) /* : void */
    {
        $this->tablePrefix = $prefix;
    }

    /**
     * Expressionize elements.
     *
     * @param array  $elements Elements
     * @param string $prefix   Prefix for table
     *
     * @return string
     *
     * @since  1.0.0
     */
    protected function expressionizeTableColumn(array $elements, string $prefix = '') : string
    {
        $expression = '';

        foreach ($elements as $key => $element) {
            if (is_string($element) && $element !== '*') {
                if (strpos($element, '.') === false) {
                    $prefix = '';
                }

                $expression .= $this->compileSystem($element, $prefix) . ', ';
            } elseif (is_string($element) && $element === '*') {
                $expression .= '*, ';
            } elseif ($element instanceof \Closure) {
                $expression .= $element() . ', ';
            } elseif ($element instanceof BuilderAbstract) {
                $expression .= $element->toSql() . ', ';
            } else {
                throw new \InvalidArgumentException();
            }
        }

        return rtrim($expression, ', ');
    }

    /**
     * Expressionize elements.
     *
     * @param array  $elements Elements
     * @param string $prefix   Prefix for table
     *
     * @return string
     *
     * @since  1.0.0
     */
    protected function expressionizeTable(array $elements, string $prefix = '') : string
    {
        $expression = '';

        foreach ($elements as $key => $element) {
            if (is_string($element) && $element !== '*') {
                $expression .= $this->compileSystem($element, $prefix) . ', ';
            } elseif (is_string($element) && $element === '*') {
                $expression .= '*, ';
            } elseif ($element instanceof \Closure) {
                $expression .= $element() . ', ';
            } elseif ($element instanceof BuilderAbstract) {
                $expression .= $element->toSql() . ', ';
            } else {
                throw new \InvalidArgumentException();
            }
        }

        return rtrim($expression, ', ');
    }

    /**
     * Compile system.
     *
     * A system is a table, a sub query or special keyword.
     *
     * @param array|string $system System
     * @param string       $prefix Prefix for table
     *
     * @return string
     *
     * @since  1.0.0
     */
    protected function compileSystem($system, string $prefix = '') : string
    {
        // todo: this is a bad way to handle select count(*) which doesn't need a prefix. Maybe remove prefixes in total?
        $identifier = $this->systemIdentifier;
        
        foreach ($this->specialKeywords as $keyword) {
            if ($keyword === '' || strrpos($system, $keyword, -strlen($system)) !== false) {
                $prefix = '';
                $identifier = '';
            }
        }

        // todo: move remaining * test also here not just if .* but also if * (should be done in else?)
        if (count($split = explode('.', $system)) == 2) {
            if ($split[1] === '*') {
                $system = $split[1];
            } else {
                $system = $this->compileSystem($split[1]);
            }

            return $this->compileSystem($prefix . $split[0]) . '.' . $system;
        } else {
            return $identifier . $prefix . $system . $identifier;
        }
    }

}
