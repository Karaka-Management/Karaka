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
namespace Modules\Accounting\Admin;

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
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'accounting_account` (
                            `accounting_account_id` int(11) NOT NULL AUTO_INCREMENT,
                            `accounting_account_name` varchar(25) NOT NULL,
                            `accounting_account_description` varchar(255) NOT NULL,
                            `accounting_account_type` tinyint(1) NOT NULL,
                            `accounting_account_parent` int(11) NOT NULL,
                            PRIMARY KEY (`accounting_account_id`),
                            KEY `accounting_account_parent` (`accounting_account_parent`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'accounting_account`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'accounting_account_ibfk_1` FOREIGN KEY (`accounting_account_parent`) REFERENCES `' . $dbPool->get()->prefix . 'accounting_account` (`accounting_account_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'accounting_batch` (
                            `accounting_batch_id` int(11) NOT NULL AUTO_INCREMENT,
                            `accounting_batch_title` varchar(30) NOT NULL,
                            `accounting_batch_creator` int(11) NOT NULL,
                            `accounting_batch_created`datetime NOT NULL,
                            `accounting_batch_type` tinyint(1) NOT NULL,
                            PRIMARY KEY (`accounting_batch_id`),
                            KEY `accounting_batch_creator` (`accounting_batch_creator`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'accounting_batch`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'accounting_batch_ibfk_1` FOREIGN KEY (`accounting_batch_creator`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'accounting_posting` (
                            `accounting_posting_id` int(11) NOT NULL AUTO_INCREMENT,
                            `accounting_posting_batch` int(11) NOT NULL,
                            `accounting_posting_receipt` int(11) DEFAULT NULL,
                            `accounting_posting_receipt_ext` int(11) DEFAULT NULL,
                            `accounting_posting_price` decimal(11,3) NOT NULL,
                            `accounting_posting_affiliation` datetime NOT NULL,
                            PRIMARY KEY (`accounting_posting_id`),
                            KEY `accounting_posting_batch` (`accounting_posting_batch`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'accounting_posting`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'accounting_posting_ibfk_1` FOREIGN KEY (`accounting_posting_batch`) REFERENCES `' . $dbPool->get()->prefix . 'accounting_batch` (`accounting_batch_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'accounting_posting_ele` (
                            `accounting_posting_ele_id` int(11) NOT NULL AUTO_INCREMENT,
                            `accounting_posting_ele_type` tinyint(1) NOT NULL,
                            `accounting_posting_ele_account` int(11) NOT NULL,
                            `accounting_posting_ele_value` decimal(11,3) NOT NULL,
                            `accounting_posting_ele_tax` tinyint(1) NOT NULL,
                            PRIMARY KEY (`accounting_posting_ele_id`),
                            KEY `accounting_posting_ele_account` (`accounting_posting_ele_account`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'accounting_posting_ele`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'accounting_posting_ele_ibfk_1` FOREIGN KEY (`accounting_posting_ele_account`) REFERENCES `' . $dbPool->get()->prefix . 'accounting_account` (`accounting_account_id`);'
                )->execute();

                /*
                 * type = (offer, confirmation etc.)
                 * soptained = date of when we received the service/order (not the invoice)
                 * check = person who checked or is supposed to check the invoice
                 * checked = date of when the invoice got approved (no datetime = no approval)
                 * posting referes (direct)
                 * payment referes to this (indirect)
                 * status {
                 *  blank
                 *  received-ok
                 *  received-notok
                 *  checked-ok
                 *  checked-notok
                 *  posted-ok
                 *  posted-notok
                 *  payed-ok
                 *  payed-notok
                 * }
                 */
                /*
                 * TODO: Purchasing can create. person who creates automatically get's permission for these to read.
                 * TODO: move to different module
                 */
                /*
                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'accounting_invoices_process` (
                        `AccountingInvoiceProcessID` int(11) NOT NULL AUTO_INCREMENT,
                        `media` int(11) DEFAULT NULL,
                        `type` tinyint(1) DEFAULT NULL,
                        `supplier` int(11) DEFAULT NULL,
                        `sname` varchar(32) DEFAULT NULL,
                        `optained` datetime NOT NULL,
                        `soptained` datetime NOT NULL,
                        `refnumber` varchar(24) NOT NULL,
                        `invoicedate` datetime NOT NULL,
                        `internalref` int(11) NOT NULL,
                        `due` datetime NOT NULL,
                        `duediscount` datetime NOT NULL,
                        `amount` decimal(11,3) NOT NULL,
                        `amountdiscount` decimal(11,3) NOT NULL,
                        `order` int(11) DEFAULT NULL,
                        `arrival` int(11) DEFAULT NULL,
                        `dnote` int(11) DEFAULT NULL,
                        PRIMARY KEY (`AccountingInvoiceProcessID`),
                        KEY `media` (`media`),
                        KEY `order` (`order`),
                        KEY `arrival` (`arrival`),
                        KEY `dnote` (`dnote`)
                    )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'accounting_invoices_process`
                        ADD CONSTRAINT `' . $dbPool->get()->prefix . 'accounting_invoices_process_ibfk_1` FOREIGN KEY (`media`) REFERENCES `' . $dbPool->get()->prefix . 'media` (`media_id`),
                        ADD CONSTRAINT `' . $dbPool->get()->prefix . 'accounting_invoices_process_ibfk_2` FOREIGN KEY (`order`) REFERENCES `' . $dbPool->get()->prefix . 'purchase_invoices` (`PurchaseInvoiceID`),
                        ADD CONSTRAINT `' . $dbPool->get()->prefix . 'accounting_invoices_process_ibfk_3` FOREIGN KEY (`arrival`) REFERENCES `' . $dbPool->get()->prefix . 'warehousing_arrival` (`WarehousingArrivalID`),
                        ADD CONSTRAINT `' . $dbPool->get()->prefix . 'accounting_invoices_process_ibfk_4` FOREIGN KEY (`dnote`) REFERENCES `' . $dbPool->get()->prefix . 'purchase_dnote` (`PurchaseDnoteID`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'accounting_invoices_status` (
                        `AccountingInvoiceStatusID` int(11) NOT NULL AUTO_INCREMENT,
                        `invoice` int(11) DEFAULT NULL,
                        `status` tinyint(1) DEFAULT NULL,
                        `person` int(11) DEFAULT NULL,
                        `changed` datetime DEFAULT NULL,
                        `info` varchar(256) NOT NULL,
                        PRIMARY KEY (`AccountingInvoiceStatusID`),
                        KEY `invoice` (`invoice`),
                        KEY `person` (`person`)
                    )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'accounting_invoices_status`
                        ADD CONSTRAINT `' . $dbPool->get()->prefix . 'accounting_invoices_status_ibfk_1` FOREIGN KEY (`invoice`) REFERENCES `' . $dbPool->get()->prefix . 'accounting_invoices_process` (`AccountingInvoiceProcessID`),
                        ADD CONSTRAINT `' . $dbPool->get()->prefix . 'accounting_invoices_status_ibfk_2` FOREIGN KEY (`person`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'accounting_invoices_process_permission` (
                        `AccountingInvoiceProcessPermissionID` int(11) NOT NULL AUTO_INCREMENT,
                        `process` int(11) DEFAULT NULL,
                        `person` int(11) DEFAULT NULL,
                        `permission` int(11) DEFAULT NULL,
                        PRIMARY KEY (`AccountingInvoiceProcessPermissionID`),
                        KEY `person` (`person`),
                        KEY `process` (`process`)
                    )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'accounting_invoices_process_permission`
                        ADD CONSTRAINT `' . $dbPool->get()->prefix . 'accounting_invoices_process_permission_ibfk_1` FOREIGN KEY (`person`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`),
                        ADD CONSTRAINT `' . $dbPool->get()->prefix . 'accounting_invoices_process_permission_ibfk_2` FOREIGN KEY (`process`) REFERENCES `' . $dbPool->get()->prefix . 'accounting_invoices_process` (`AccountingInvoiceProcessID`);'
                )->execute();*/
                break;
        }
    }
}
