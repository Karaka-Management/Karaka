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
namespace Modules\Organization\Admin;

use phpOMS\DataStorage\Database\DatabaseType;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Module\InfoManager;
use phpOMS\Module\InstallerAbstract;

/**
 * Organization install class.
 *
 * @category   Modules
 * @package    Modules\Organization
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
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'organization_unit` (
                            `organization_unit_id` int(11) NOT NULL AUTO_INCREMENT,
                            `organization_unit_name` varchar(50) DEFAULT NULL,
                            `organization_unit_description` varchar(255) DEFAULT NULL,
                            `organization_unit_parent` int(11) DEFAULT NULL,
                            `organization_unit_status` int(3) DEFAULT NULL,
                            PRIMARY KEY (`organization_unit_id`),
                            KEY `organization_unit_parent` (`organization_unit_parent`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'organization_unit`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'organization_unit_ibfk_1` FOREIGN KEY (`organization_unit_parent`) REFERENCES `' . $dbPool->get()->prefix . 'organization_unit` (`organization_unit_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'organization_department` (
                            `organization_department_id` int(11) NOT NULL AUTO_INCREMENT,
                            `organization_department_name` varchar(30) DEFAULT NULL,
                            `organization_department_description` varchar(255) DEFAULT NULL,
                            `organization_department_parent` int(11) DEFAULT NULL,
                            `organization_department_status` int(3) DEFAULT NULL,
                            `organization_department_unit` int(11) NOT NULL,
                            PRIMARY KEY (`organization_department_id`),
                            KEY `organization_department_parent` (`organization_department_parent`),
                            KEY `organization_department_unit` (`organization_department_unit`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'organization_department`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'organization_department_ibfk_1` FOREIGN KEY (`organization_department_parent`) REFERENCES `' . $dbPool->get()->prefix . 'organization_department` (`organization_department_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'organization_department_ibfk_2` FOREIGN KEY (`organization_department_unit`) REFERENCES `' . $dbPool->get()->prefix . 'organization_unit` (`organization_unit_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'organization_position` (
                            `organization_position_id` int(11) NOT NULL AUTO_INCREMENT,
                            `organization_position_name` varchar(50) DEFAULT NULL,
                            `organization_position_description` varchar(255) DEFAULT NULL,
                            `organization_position_parent` int(11) DEFAULT NULL,
                            `organization_position_department` int(11) DEFAULT NULL,
                            `organization_position_status` int(3) DEFAULT NULL,
                            PRIMARY KEY (`organization_position_id`),
                            KEY `organization_position_parent` (`organization_position_parent`),
                            KEY `organization_position_department` (`organization_position_department`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'organization_position`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'organization_position_ibfk_1` FOREIGN KEY (`organization_position_parent`) REFERENCES `' . $dbPool->get()->prefix . 'organization_position` (`organization_position_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'organization_position_ibfk_2` FOREIGN KEY (`organization_position_department`) REFERENCES `' . $dbPool->get()->prefix . 'organization_department` (`organization_department_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'organization_address` (
                            `organization_address_id` int(11) NOT NULL AUTO_INCREMENT,
                            `organization_address_status` tinyint(2) DEFAULT NULL,
                            `organization_address_matchcode` varchar(50) DEFAULT NULL,
                            `organization_address_name` varchar(50) DEFAULT NULL,
                            `organization_address_fao` varchar(30) DEFAULT NULL,
                            `organization_address_addr` varchar(50) DEFAULT NULL,
                            `organization_address_city` varchar(20) DEFAULT NULL,
                            `organization_address_zip` varchar(20) DEFAULT NULL,
                            `organization_address_state` varchar(20) DEFAULT NULL,
                            `organization_address_country` varchar(30) DEFAULT NULL,
                            `organization_address_unit` int(11) DEFAULT NULL,
                            PRIMARY KEY (`organization_address_id`),
                            KEY `organization_address_unit` (`organization_address_unit`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'organization_address`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'organization_address_ibfk_1` FOREIGN KEY (`organization_address_unit`) REFERENCES `' . $dbPool->get()->prefix . 'organization_unit` (`organization_unit_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'INSERT INTO `' . $dbPool->get()->prefix . 'organization_unit` (`organization_unit_name`, `organization_unit_description`, `organization_unit_parent`) VALUES
                            (\'Orange Management\', \'Orange Management\', NULL);'
                )->execute();
                break;
        }
    }
}
