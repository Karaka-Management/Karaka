<?php
/**
 * Orange Management
 *
 * PHP Version 7.4
 *
 * @package   Model
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Model;

use phpOMS\Config\SettingsAbstract;
use phpOMS\DataStorage\Database\Connection\ConnectionAbstract;

/**
 * Core settings class.
 *
 * This is used in order to manage global Framework and Module settings
 *
 * @package Model
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
final class CoreSettings extends SettingsAbstract
{

    /**
     * Settings table.
     *
     * @var   string
     * @since 1.0.0
     */
    protected static ?string $table = 'settings';

    /**
     * Columns.
     *
     * @var   string[]
     * @since 1.0.0
     */
    protected static array $columns = [
        'settings_id',
        'settings_content',
    ];

    /**
     * Constructor.
     *
     * @param ConnectionAbstract $connection Database connection
     *
     * @since 1.0.0
     */
    public function __construct(ConnectionAbstract $connection)
    {
        $this->connection = $connection;
    }
}
