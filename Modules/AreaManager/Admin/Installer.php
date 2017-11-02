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
namespace Modules\AreaManager\Admin;

use phpOMS\DataStorage\Database\DatabaseType;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Module\InfoManager;
use phpOMS\Module\InstallerAbstract;

/**
 * Area manager class.
 *
 * @category   Modules
 * @package    Modules\Admin
 * @license    OMS License 1.0
 * @link       http://orange-management.com
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
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'area_manager_area` (
                            `area_manager_area_id` int(11) NOT NULL AUTO_INCREMENT,
                            `area_manager_area_name` varchar(50) NOT NULL,
                            PRIMARY KEY (`area_manager_area_id`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'area_manager_account` (
                            `area_manager_account_id` int(11) NOT NULL AUTO_INCREMENT,
                            `area_manager_account_start` datetime NOT NULL,
                            `area_manager_account_end` datetime NOT NULL,
                            `area_manager_account_account` int(11) NOT NULL,
                            `area_manager_account_area` int(11) NOT NULL,
                            PRIMARY KEY (`area_manager_account_id`),
                            KEY `area_manager_account_account` (`area_manager_account_account`),
                            KEY `area_manager_account_area` (`area_manager_account_area`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'area_manager_account`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'area_manager_account_ibfk_1` FOREIGN KEY (`area_manager_account_account`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'area_manager_account_ibfk_2` FOREIGN KEY (`area_manager_account_area`) REFERENCES `' . $dbPool->get()->prefix . 'area_manager_area` (`area_manager_area_id`);'
                )->execute();
                break;
        }
    }
}
