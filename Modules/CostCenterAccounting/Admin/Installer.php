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
namespace Modules\CostCenterAccounting\Admin;

use phpOMS\DataStorage\Database\DatabaseType;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Module\InfoManager;
use phpOMS\Module\InstallerAbstract;

/**
 * Navigation class.
 *
 * @category   Modules
 * @package    Modules\Admin
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Installer extends InstallerAbstract
{

    /**
     * {@inheritdoc}
     */
    public static function install(string $path, DatabasePool $dbPool, InfoManager $info)
    {
        parent::install(__DIR__ . '/..', $dbPool, $info);

        switch ($dbPool->get()->getType()) {
            case DatabaseType::MYSQL:
                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'cost_center_accounting` (
                            `cost_center_accounting_id` int(11) NOT NULL AUTO_INCREMENT,
                            `cost_center_accounting_name` varchar(25) NOT NULL,
                            `cost_center_accounting_description` varchar(255) NOT NULL,
                            `cost_center_accounting_parent` int(11) NOT NULL,
                            PRIMARY KEY (`cost_center_accounting_id`),
                            KEY `cost_center_accounting_parent` (`cost_center_accounting_parent`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'cost_center_accounting`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'cost_center_accounting_ibfk_1` FOREIGN KEY (`cost_center_accounting_parent`) REFERENCES `' . $dbPool->get()->prefix . 'cost_center_accounting` (`cost_center_accounting_id`);'
                )->execute();

                break;
        }
    }
}
