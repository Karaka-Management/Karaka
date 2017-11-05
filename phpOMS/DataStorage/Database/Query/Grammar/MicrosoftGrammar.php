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
class MicrosoftGrammar extends Grammar
{
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

        $query->limit = $query->limit ?? 1;

        return 'SELECT TOP ' . $query->limit . ' ' . $expression . ' ' . $this->compileFrom($query, $query->from) . ' ORDER BY IDX FETCH FIRST ' . $query->limit . ' ROWS ONLY';
    }
}
