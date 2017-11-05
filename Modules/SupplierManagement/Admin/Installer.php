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
namespace Modules\SupplierManagement\Admin;

use phpOMS\DataStorage\Database\DatabaseType;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Module\InfoManager;
use phpOMS\Module\InstallerAbstract;

/**
 * Purchase install class.
 *
 * @category   Modules
 * @package    Modules\Purchase
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
                $dbPool->get()->con->beginTransaction();

                $dbPool->get()->con->prepare(/* todo: maybe add supplier logo? */
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'suppliermgmt_supplier` (
                            `suppliermgmt_supplier_id` int(11) NOT NULL AUTO_INCREMENT,
                            `suppliermgmt_supplier_no` int(11) NOT NULL,
                            `suppliermgmt_supplier_no_reverse` varchar(25) DEFAULT NULL,
                            `suppliermgmt_supplier_status` tinyint(2) NOT NULL,
                            `suppliermgmt_supplier_type` tinyint(2) NOT NULL,
                            `suppliermgmt_supplier_taxid` varchar(50) DEFAULT NULL,
                            `suppliermgmt_supplier_info` text DEFAULT NULL,
                            `suppliermgmt_supplier_created_at` datetime NOT NULL,
                            `suppliermgmt_supplier_account` int(11) NOT NULL,
                            PRIMARY KEY (`suppliermgmt_supplier_id`),
                            KEY `suppliermgmt_supplier_account` (`suppliermgmt_supplier_account`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'suppliermgmt_supplier`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'suppliermgmt_supplier_ibfk_1` FOREIGN KEY (`suppliermgmt_supplier_account`) REFERENCES `' . $dbPool->get()->prefix . 'profile_account` (`profile_account_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'suppliermgmt_supplier_address` (
                            `suppliermgmt_supplier_address_id` int(11) NOT NULL AUTO_INCREMENT,
                            `suppliermgmt_supplier_address_supplier` int(11) NOT NULL,
                            `suppliermgmt_supplier_address_address` int(11) NOT NULL,
                            `suppliermgmt_supplier_address_type` tinyint(2) NOT NULL,
                            PRIMARY KEY (`suppliermgmt_supplier_address_id`),
                            KEY `suppliermgmt_supplier_address_supplier` (`suppliermgmt_supplier_address_supplier`),
                            KEY `suppliermgmt_supplier_address_address` (`suppliermgmt_supplier_address_address`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'suppliermgmt_supplier_address`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'suppliermgmt_supplier_address_ibfk_1` FOREIGN KEY (`suppliermgmt_supplier_address_supplier`) REFERENCES `' . $dbPool->get()->prefix . 'suppliermgmt_supplier` (`suppliermgmt_supplier_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'suppliermgmt_supplier_address_ibfk_2` FOREIGN KEY (`suppliermgmt_supplier_address_address`) REFERENCES `' . $dbPool->get()->prefix . 'profile_address` (`profile_address_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'suppliermgmt_supplier_contactelement` (
                            `suppliermgmt_supplier_contactelement_id` int(11) NOT NULL AUTO_INCREMENT,
                            `suppliermgmt_supplier_contactelement_dst` int(11) NOT NULL,
                            `suppliermgmt_supplier_contactelement_src` int(11) NOT NULL,
                            `suppliermgmt_supplier_contactelement_type` tinyint(2) NOT NULL,
                            PRIMARY KEY (`suppliermgmt_supplier_contactelement_id`),
                            KEY `suppliermgmt_supplier_contactelement_dst` (`suppliermgmt_supplier_contactelement_dst`),
                            KEY `suppliermgmt_supplier_contactelement_src` (`suppliermgmt_supplier_contactelement_src`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'suppliermgmt_supplier_contactelement`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'suppliermgmt_supplier_contactelement_ibfk_1` FOREIGN KEY (`suppliermgmt_supplier_contactelement_src`) REFERENCES `' . $dbPool->get()->prefix . 'suppliermgmt_supplier` (`suppliermgmt_supplier_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'suppliermgmt_supplier_contactelement_ibfk_2` FOREIGN KEY (`suppliermgmt_supplier_contactelement_dst`) REFERENCES `' . $dbPool->get()->prefix . 'profile_contactelement` (`profile_contactelement_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'suppliermgmt_supplier_media` (
                            `suppliermgmt_supplier_media_id` int(11) NOT NULL AUTO_INCREMENT,
                            `suppliermgmt_supplier_media_dst` int(11) NOT NULL,
                            `suppliermgmt_supplier_media_src` int(11) NOT NULL,
                            `suppliermgmt_supplier_media_type` tinyint(2) NOT NULL,
                            PRIMARY KEY (`suppliermgmt_supplier_media_id`),
                            KEY `suppliermgmt_supplier_media_dst` (`suppliermgmt_supplier_media_dst`),
                            KEY `suppliermgmt_supplier_media_src` (`suppliermgmt_supplier_media_src`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'suppliermgmt_supplier_media`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'suppliermgmt_supplier_media_ibfk_1` FOREIGN KEY (`suppliermgmt_supplier_media_src`) REFERENCES `' . $dbPool->get()->prefix . 'suppliermgmt_supplier` (`suppliermgmt_supplier_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'suppliermgmt_supplier_media_ibfk_2` FOREIGN KEY (`suppliermgmt_supplier_media_dst`) REFERENCES `' . $dbPool->get()->prefix . 'media` (`media_id`);'
                )->execute();

                $dbPool->get()->con->commit();
                break;
        }
    }
}
