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
namespace Modules\WarehouseManagement\Admin;

use phpOMS\DataStorage\Database\DatabaseType;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Module\InfoManager;
use phpOMS\Module\InstallerAbstract;

/**
 * Navigation class.
 *
 * @category   Modules
 * @package    Framework
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
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'warehousing_stock` (
                            `WarehousingStockID` int(11) NOT NULL AUTO_INCREMENT,
                            `name` varchar(50) DEFAULT NULL,
                            PRIMARY KEY (`WarehousingStockID`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'warehousing_stock_location` (
                            `WarehousingStockLocationID` int(11) NOT NULL AUTO_INCREMENT,
                            `name` varchar(50) DEFAULT NULL,
                            `stock` int(11) DEFAULT NULL,
                            PRIMARY KEY (`WarehousingStockLocationID`),
                            KEY `stock` (`stock`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'warehousing_stock_location`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'warehousing_stock_location_ibfk_1` FOREIGN KEY (`stock`) REFERENCES `' . $dbPool->get()->prefix . 'warehousing_stock` (`WarehousingStockID`);'
                )->execute();

                // TODO: complete
                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'warehousing_article` (
                            `WarehousingArticleID` int(11) NOT NULL AUTO_INCREMENT,
                            `weight` int(11) DEFAULT NULL,
                            `dimension` varchar(17) DEFAULT NULL,
                            `volume` int(11) DEFAULT NULL,
                            `lot` tinyint(1) DEFAULT NULL,
                            `status` tinyint(2) DEFAULT NULL,
                            PRIMARY KEY (`WarehousingArticleID`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'warehousing_article_disposal` (
                            `WarehousingArticleID` int(11) NOT NULL AUTO_INCREMENT,
                            `glas` int(11) DEFAULT NULL,
                            `paper` int(11) DEFAULT NULL,
                            `sheet` int(11) DEFAULT NULL,
                            `aluminium` int(11) DEFAULT NULL,
                            `synthetic` int(11) DEFAULT NULL,
                            `cardboard` int(11) DEFAULT NULL,
                            `composites` int(11) DEFAULT NULL,
                            `organic` int(11) DEFAULT NULL,
                            `pe` int(11) DEFAULT NULL,
                            `misc` int(11) DEFAULT NULL,
                            PRIMARY KEY (`WarehousingArticleID`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                // WE kann von client oder supplier kommen, deswegen type
                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'warehousing_arrival` (
                            `WarehousingArrivalID` int(11) NOT NULL AUTO_INCREMENT,
                            `arrivaldate` datetime DEFAULT NULL,
                            `from` int(11) DEFAULT NULL,
                            `type` tinyint(1) DEFAULT NULL,
                            `media` int(11) DEFAULT NULL,
                            `pcondition` tinyint(1) DEFAULT NULL,
                            `acondition` tinyint(1) DEFAULT NULL,
                            `amount` tinyint(1) DEFAULT NULL,
                            `checked` int(11) DEFAULT NULL,
                            `dnote` int(11) DEFAULT NULL,
                            PRIMARY KEY (`WarehousingArrivalID`),
                            KEY `checked` (`checked`),
                            KEY `dnote` (`dnote`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'warehousing_arrival`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'warehousing_arrival_ibfk_1` FOREIGN KEY (`checked`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`);'
                )->execute();

                /* info: amount will get increased and reduced based on invoices -> will result in a high amount of entries where the amount is 0 -> long lookup times for available lot lookup?! */
                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'warehousing_article_stock` (
                            `WarehousingArticleStockID` int(11) NOT NULL AUTO_INCREMENT,
                            `article` int(11) DEFAULT NULL,
                            `lot` varchar(256) DEFAULT NULL,
                            `sn` varchar(256) DEFAULT NULL,
                            `durability` datetime DEFAULT NULL,
                            `arrival` int(11) DEFAULT NULL,
                            `amount` mediumint(9) DEFAULT NULL,
                            `location` int(11) DEFAULT NULL,
                            PRIMARY KEY (`WarehousingArticleStockID`),
                            KEY `article` (`article`),
                            KEY `arrival` (`arrival`),
                            KEY `location` (`location`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'warehousing_article_stock`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'warehousing_article_stock_ibfk_1` FOREIGN KEY (`article`) REFERENCES `' . $dbPool->get()->prefix . 'warehousing_article` (`WarehousingArticleID`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'warehousing_article_stock_ibfk_2` FOREIGN KEY (`arrival`) REFERENCES `' . $dbPool->get()->prefix . 'warehousing_arrival` (`WarehousingArrivalID`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'warehousing_article_stock_ibfk_3` FOREIGN KEY (`location`) REFERENCES `' . $dbPool->get()->prefix . 'warehousing_stock_location` (`WarehousingStockLocationID`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'warehousing_arrival_transfer` (
                            `WarehousingArrivalTransferID` int(11) NOT NULL AUTO_INCREMENT,
                            `location` int(11) DEFAULT NULL,
                            `amount` int(11) DEFAULT NULL,
                            `arrival` int(11) DEFAULT NULL,
                            PRIMARY KEY (`WarehousingArrivalTransferID`),
                            KEY `location` (`location`),
                            KEY `arrival` (`arrival`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'warehousing_arrival_transfer`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'warehousing_arrival_transfer_ibfk_1` FOREIGN KEY (`location`) REFERENCES `' . $dbPool->get()->prefix . 'warehousing_article_stock` (`WarehousingArticleStockID`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'warehousing_arrival_transfer_ibfk_2` FOREIGN KEY (`arrival`) REFERENCES `' . $dbPool->get()->prefix . 'warehousing_arrival` (`WarehousingArrivalID`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'warehousing_article_transfer` (
                            `WarehousingArticleTransferID` int(11) NOT NULL AUTO_INCREMENT,
                            `name` varchar(50) DEFAULT NULL,
                            `creator` int(11) DEFAULT NULL,
                            `created` datetime DEFAULT NULL,
                            PRIMARY KEY (`WarehousingArticleTransferID`),
                            KEY `creator` (`creator`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'warehousing_article_transfer`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'warehousing_article_transfer_ibfk_1` FOREIGN KEY (`creator`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'warehousing_article_transfer_single` (
                            `WarehousingArticleStockID` int(11) NOT NULL AUTO_INCREMENT,
                            `old` int(11) DEFAULT NULL,
                            `new` int(11) DEFAULT NULL,
                            `amount` int(11) DEFAULT NULL,
                            `transfer` int(11) DEFAULT NULL,
                            PRIMARY KEY (`WarehousingArticleStockID`),
                            KEY `old` (`old`),
                            KEY `new` (`new`),
                            KEY `transfer` (`transfer`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'warehousing_article_transfer_single`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'warehousing_article_transfer_single_ibfk_1` FOREIGN KEY (`old`) REFERENCES `' . $dbPool->get()->prefix . 'warehousing_article_stock` (`WarehousingArticleStockID`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'warehousing_article_transfer_single_ibfk_2` FOREIGN KEY (`new`) REFERENCES `' . $dbPool->get()->prefix . 'warehousing_article_stock` (`WarehousingArticleStockID`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'warehousing_article_transfer_single_ibfk_3` FOREIGN KEY (`transfer`) REFERENCES `' . $dbPool->get()->prefix . 'warehousing_article_transfer` (`WarehousingArticleTransferID`);'
                )->execute();

                // TODO: maybe consider chaning shipCountry varchar to size 55 (based on ISO 3166-1) (same goes for sales department tables)
                // TODO: create shipFrom table = business address of your company (maybe multiple)
                // TODO: implement ups fields make sure to use multiple tables (multiple packages)
                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'warehousing_shipping` (
                            `WarehousingShippingID` int(11) NOT NULL AUTO_INCREMENT,
                            `shippingdate` datetime DEFAULT NULL,
                            `shipTo` varchar(50) DEFAULT NULL,
                            `shipFAO` varchar(30) DEFAULT NULL,
                            `shipAddr` varchar(50) DEFAULT NULL,
                            `shipCity` varchar(20) DEFAULT NULL,
                            `shipState` varchar(30) DEFAULT NULL,
                            `shipZip` varchar(20) DEFAULT NULL,
                            `shipCountry` varchar(30) DEFAULT NULL,
                            `shipPhone` varchar(30) DEFAULT NULL,
                            `shipFrom` int(11) DEFAULT NULL,
                            `carrier` varchar(30) DEFAULT NULL,
                            `tracking` varchar(7089) DEFAULT NULL,
                            `client` int(11) DEFAULT NULL,
                            `invoice` int(11) DEFAULT NULL,
                            `shipped` int(11) DEFAULT NULL,
                            PRIMARY KEY (`WarehousingShippingID`),
                            KEY `shipFrom` (`shipFrom`),
                            KEY `shipped` (`shipped`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'warehousing_shipping`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'warehousing_shipping_ibfk_1` FOREIGN KEY (`shipFrom`) REFERENCES `' . $dbPool->get()->prefix . 'organization_address` (`organization_address_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'warehousing_shipping_ibfk_2` FOREIGN KEY (`shipped`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`);'
                )->execute();

                break;
        }
    }
}
