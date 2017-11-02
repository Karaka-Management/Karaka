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
namespace Modules\ClientManagement\Admin;

use phpOMS\DataStorage\Database\DatabaseType;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Module\InfoManager;
use phpOMS\Module\InstallerAbstract;

/**
 * Client Management install class.
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
                $dbPool->get()->con->beginTransaction();

                $dbPool->get()->con->prepare(/* todo: maybe add client logo? */
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'clientmgmt_client` (
                            `clientmgmt_client_id` int(11) NOT NULL AUTO_INCREMENT,
                            `clientmgmt_client_no` int(11) NOT NULL,
                            `clientmgmt_client_no_reverse` varchar(25) DEFAULT NULL,
                            `clientmgmt_client_status` tinyint(2) NOT NULL,
                            `clientmgmt_client_type` tinyint(2) NOT NULL,
                            `clientmgmt_client_taxid` varchar(50) DEFAULT NULL,
                            `clientmgmt_client_info` text DEFAULT NULL,
                            `clientmgmt_client_created_at` datetime NOT NULL,
                            `clientmgmt_client_account` int(11) NOT NULL,
                            PRIMARY KEY (`clientmgmt_client_id`),
                            KEY `clientmgmt_client_account` (`clientmgmt_client_account`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'clientmgmt_client`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'clientmgmt_client_ibfk_1` FOREIGN KEY (`clientmgmt_client_account`) REFERENCES `' . $dbPool->get()->prefix . 'profile_account` (`profile_account_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'clientmgmt_client_address` (
                            `clientmgmt_client_address_id` int(11) NOT NULL AUTO_INCREMENT,
                            `clientmgmt_client_address_client` int(11) NOT NULL,
                            `clientmgmt_client_address_address` int(11) NOT NULL,
                            `clientmgmt_client_address_type` tinyint(2) NOT NULL,
                            PRIMARY KEY (`clientmgmt_client_address_id`),
                            KEY `clientmgmt_client_address_client` (`clientmgmt_client_address_client`),
                            KEY `clientmgmt_client_address_address` (`clientmgmt_client_address_address`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'clientmgmt_client_address`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'clientmgmt_client_address_ibfk_1` FOREIGN KEY (`clientmgmt_client_address_client`) REFERENCES `' . $dbPool->get()->prefix . 'clientmgmt_client` (`clientmgmt_client_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'clientmgmt_client_address_ibfk_2` FOREIGN KEY (`clientmgmt_client_address_address`) REFERENCES `' . $dbPool->get()->prefix . 'profile_address` (`profile_address_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'clientmgmt_client_contactelement` (
                            `clientmgmt_client_contactelement_id` int(11) NOT NULL AUTO_INCREMENT,
                            `clientmgmt_client_contactelement_dst` int(11) NOT NULL,
                            `clientmgmt_client_contactelement_src` int(11) NOT NULL,
                            `clientmgmt_client_contactelement_type` tinyint(2) NOT NULL,
                            PRIMARY KEY (`clientmgmt_client_contactelement_id`),
                            KEY `clientmgmt_client_contactelement_dst` (`clientmgmt_client_contactelement_dst`),
                            KEY `clientmgmt_client_contactelement_src` (`clientmgmt_client_contactelement_src`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'clientmgmt_client_contactelement`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'clientmgmt_client_contactelement_ibfk_1` FOREIGN KEY (`clientmgmt_client_contactelement_src`) REFERENCES `' . $dbPool->get()->prefix . 'clientmgmt_client` (`clientmgmt_client_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'clientmgmt_client_contactelement_ibfk_2` FOREIGN KEY (`clientmgmt_client_contactelement_dst`) REFERENCES `' . $dbPool->get()->prefix . 'profile_contactelement` (`profile_contactelement_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'clientmgmt_client_media` (
                            `clientmgmt_client_media_id` int(11) NOT NULL AUTO_INCREMENT,
                            `clientmgmt_client_media_dst` int(11) NOT NULL,
                            `clientmgmt_client_media_src` int(11) NOT NULL,
                            `clientmgmt_client_media_type` tinyint(2) NOT NULL,
                            PRIMARY KEY (`clientmgmt_client_media_id`),
                            KEY `clientmgmt_client_media_dst` (`clientmgmt_client_media_dst`),
                            KEY `clientmgmt_client_media_src` (`clientmgmt_client_media_src`)
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'clientmgmt_client_media`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'clientmgmt_client_media_ibfk_1` FOREIGN KEY (`clientmgmt_client_media_src`) REFERENCES `' . $dbPool->get()->prefix . 'clientmgmt_client` (`clientmgmt_client_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'clientmgmt_client_media_ibfk_2` FOREIGN KEY (`clientmgmt_client_media_dst`) REFERENCES `' . $dbPool->get()->prefix . 'media` (`media_id`);'
                )->execute();

                $dbPool->get()->con->commit();
                break;
        }
    }
}
