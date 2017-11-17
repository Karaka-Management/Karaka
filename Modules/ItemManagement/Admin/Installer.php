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
namespace Modules\ItemManagement\Admin;

use phpOMS\DataStorage\Database\DatabaseType;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Module\InfoManager;
use phpOMS\Module\InstallerAbstract;

/**
 * Item Reference install class.
 *
 * @category   Modules
 * @package    Modules\itemmgmt
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
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'itemmgmt_item` (
                            `itemmgmt_item_id` int(11) NOT NULL AUTO_INCREMENT,
                            `itemmgmt_item_no` varchar(30) DEFAULT NULL,
                            `itemmgmt_item_articlegroup` int(11) DEFAULT NULL,
                            `itemmgmt_item_salesgroup` int(11) DEFAULT NULL,
                            `itemmgmt_item_productgroup` int(11) DEFAULT NULL,
                            `itemmgmt_item_segment` int(11) DEFAULT NULL,
                            `itemmgmt_item_successor` int(11) DEFAULT NULL,
                            `itemmgmt_item_info` varchar(255) DEFAULT NULL,
                            PRIMARY KEY (`itemmgmt_item_id`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                // all types here segment, sales group etc since it's easier to create l11n references?!
                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'itemmgmt_segmentation` (
                            `itemmgmt_segmentation_id` int(11) NOT NULL AUTO_INCREMENT,
                            `itemmgmt_segmentation_type` varchar(30) DEFAULT NULL,
                            `itemmgmt_segmentation_no` varchar(30) DEFAULT NULL,
                            PRIMARY KEY (`itemmgmt_segmentation_id`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'itemmgmt_segmentation_l11n` (
                            `itemmgmt_segmentation_l11n_id` int(11) NOT NULL AUTO_INCREMENT,
                            `itemmgmt_segmentation_l11n_no` varchar(30) DEFAULT NULL,
                            `itemmgmt_segmentation_l11n_name` varchar(255) DEFAULT NULL,
                            `itemmgmt_segmentation_l11n_language` varchar(3) DEFAULT NULL,
                            PRIMARY KEY (`itemmgmt_segmentation_l11n_id`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'itemmgmt_item_media` (
                            `itemmgmt_item_media_id` int(11) NOT NULL AUTO_INCREMENT,
                            `itemmgmt_item_media_src` int(11) NOT NULL,
                            `itemmgmt_item_media_dst` int(11) NOT NULL,
                            PRIMARY KEY (`itemmgmt_item_media_id`),
                            KEY `itemmgmt_item_media_src` (`itemmgmt_item_media_src`),
                            KEY `itemmgmt_item_media_dst` (`itemmgmt_item_media_dst`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'itemmgmt_item_media`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'itemmgmt_item_media_ibfk_1` FOREIGN KEY (`itemmgmt_item_media_src`) REFERENCES `' . $dbPool->get()->prefix . 'itemmgmt_item_media` (`itemmgmt_item_media_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'itemmgmt_item_media_ibfk_2` FOREIGN KEY (`itemmgmt_item_media_dst`) REFERENCES `' . $dbPool->get()->prefix . 'media` (`media_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'itemmgmt_item_l11n` (
                            `itemmgmt_item_l11n_id` int(11) NOT NULL AUTO_INCREMENT,
                            `itemmgmt_item_l11n_language` varchar(30) DEFAULT NULL,
                            `itemmgmt_item_l11n_name1` varchar(30) DEFAULT NULL,
                            `itemmgmt_item_l11n_name2` varchar(30) DEFAULT NULL,
                            `itemmgmt_item_l11n_name3` varchar(30) DEFAULT NULL,
                            `itemmgmt_item_l11n_desc` text DEFAULT NULL,
                            `itemmgmt_item_l11n_note` text DEFAULT NULL,
                            `itemmgmt_item_l11n_item` text DEFAULT NULL,
                            PRIMARY KEY (`itemmgmt_item_l11n_id`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'itemmgmt_partslist` (
                            `itemmgmt_partslist_id` int(11) NOT NULL AUTO_INCREMENT,
                            `itemmgmt_partslist_item` int(11) DEFAULT NULL,
                            `itemmgmt_partslist_ref` int(11) DEFAULT NULL,
                            `itemmgmt_partslist_pos` int(11) DEFAULT NULL,
                            `itemmgmt_partslist_amount` int(11) DEFAULT NULL,
                            PRIMARY KEY (`itemmgmt_partslist_id`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();
            
        $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'itemmgmt_sales_price` (
                            `itemmgmt_sales_price_id` int(11) NOT NULL AUTO_INCREMENT,
                            `itemmgmt_sales_price_customer` int(11) DEFAULT NULL,
                            `itemmgmt_sales_price_group` int(11) DEFAULT NULL,
                            `itemmgmt_sales_price_amount` varchar(50) DEFAULT NULL,
                            `itemmgmt_sales_price_price` int(11) DEFAULT NULL,
                            `itemmgmt_sales_price_bonus` int(11) DEFAULT NULL,
                            `itemmgmt_sales_price_discountp` int(11) DEFAULT NULL,
                            `itemmgmt_sales_price_discount` int(11) DEFAULT NULL,
                            `itemmgmt_sales_price_item` int(11) DEFAULT NULL,
                            PRIMARY KEY (`itemmgmt_sales_price_id`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'itemmgmt_purchase` (
                            `itemmgmt_purchase_id` int(11) NOT NULL AUTO_INCREMENT,
                            `itemmgmt_purchase_item` int(11) DEFAULT NULL,
                            `itemmgmt_purchase_supplier` int(11) DEFAULT NULL,
                            `itemmgmt_purchase_order_no` varchar(50) DEFAULT NULL,
                            `itemmgmt_purchase_amount` int(11) DEFAULT NULL,
                            `itemmgmt_purchase_leadtime` int(11) DEFAULT NULL,
                            PRIMARY KEY (`itemmgmt_partslist_id`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'itemmgmt_purchase_price` (
                            `itemmgmt_purchase_price_id` int(11) NOT NULL AUTO_INCREMENT,
                            `itemmgmt_purchase_price_supplier` int(11) DEFAULT NULL,
                            `itemmgmt_purchase_price_amount` varchar(50) DEFAULT NULL,
                            `itemmgmt_purchase_price_price` int(11) DEFAULT NULL,
                            `itemmgmt_purchase_price_bonus` int(11) DEFAULT NULL,
                            `itemmgmt_purchase_price_discountp` int(11) DEFAULT NULL,
                            `itemmgmt_purchase_price_discount` int(11) DEFAULT NULL,
                            `itemmgmt_purchase_price_weight` int(11) DEFAULT NULL,
                `itemmgmt_purchase_price_item` int(11) DEFAULT NULL,
                            PRIMARY KEY (`itemmgmt_purchase_price_id`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'itemmgmt_disposal` (
                            `itemmgmt_disposal_id` int(11) NOT NULL AUTO_INCREMENT,
                            `itemmgmt_disposal_item` int(11) DEFAULT NULL,
                            `itemmgmt_disposal_type` int(11) DEFAULT NULL,
                            `itemmgmt_disposal_amount` int(11) DEFAULT NULL,
                            `itemmgmt_disposal_cost` int(11) DEFAULT NULL,
                            PRIMARY KEY (`itemmgmt_disposal_id`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                break;
        }
    }
}
