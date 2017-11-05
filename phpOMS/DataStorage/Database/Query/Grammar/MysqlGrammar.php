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

namespace phpOMS\DataStorage\Database\Query\Grammar;
use phpOMS\DataStorage\Database\Query\Builder;

/**
 * Grammar class.
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database\Query\Grammar
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class MysqlGrammar extends Grammar
{

    /**
     * System identifier.
     *
     * @var string
     * @since 1.0.0
     */
    protected $systemIdentifier = '`';

    /**
     * Compile random.
     *
     * @param Builder $query   Builder
     * @param array   $columns Columns
     *
     * @return string
     *
     * @since  1.0.0
     */
    protected function compileRandom(Builder $query, array $columns) : string
    {
        $expression = $this->expressionizeTableColumn($columns, $query->getPrefix());

        if ($expression === '') {
            $expression = '*';
        }

        return 'SELECT ' . $expression . ' ' . $this->compileFrom($query, $query->from) . ' ORDER BY RAND() ' . $this->compileLimit($query, $query->limit);
    }
}
