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
namespace Modules\Billing\Admin;

use phpOMS\DataStorage\Database\DatabaseType;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Module\InfoManager;
use phpOMS\Module\InstallerAbstract;

/**
 * Billing install class.
 *
 * @category   Modules
 * @package    Modules\Billing
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
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'billing_invoice` (
                            `billing_invoice_id` int(11) NOT NULL AUTO_INCREMENT,
                            `billing_invoice_number` varchar(255) DEFAULT NULL,
                            `billing_invoice_info` text DEFAULT NULL,
                            `billing_invoice_status` tinyint(2) DEFAULT NULL,
                            `billing_invoice_type` tinyint(2) DEFAULT NULL,
                            `billing_invoice_client` int(11) NOT NULL,

                            `billing_invoice_shipTo` varchar(255) DEFAULT NULL,
                            `billing_invoice_shipFAO` varchar(255) DEFAULT NULL,
                            `billing_invoice_shipAddr` varchar(255) DEFAULT NULL,
                            `billing_invoice_shipCity` varchar(255) DEFAULT NULL,
                            `billing_invoice_shipZip` varchar(20) DEFAULT NULL,
                            `billing_invoice_shipCountry` varchar(255) DEFAULT NULL,

                            `billing_invoice_billTo` varchar(255) DEFAULT NULL,
                            `billing_invoice_billFAO` varchar(255) DEFAULT NULL,
                            `billing_invoice_billAddr` varchar(255) DEFAULT NULL,
                            `billing_invoice_billCity` varchar(255) DEFAULT NULL,
                            `billing_invoice_billZip` varchar(20) DEFAULT NULL,
                            `billing_invoice_billCountry` varchar(255) DEFAULT NULL,

                            `billing_invoice_created_at` datetime DEFAULT NULL,
                            `billing_invoice_created_by` int(11) NOT NULL,
                            `billing_invoice_finished_at` datetime DEFAULT NULL,

                            `billing_invoice_gross` int(11) DEFAULT NULL,
                            `billing_invoice_net` int(11) DEFAULT NULL,
                            `billing_invoice_currency` varchar(3) DEFAULT NULL,
                            `billing_invoice_taxid` varchar(255) DEFAULT NULL,
                            `billing_invoice_freightage` int(11) DEFAULT NULL,
                            `billing_invoice_insurance` int(11) DEFAULT NULL,
                            
                            `billing_invoice_referer` int(11) DEFAULT NULL,
                            `billing_invoice_referer_name` int(11) DEFAULT NULL,

                            `billing_invoice_reference` int(11) DEFAULT NULL,

                            `billing_invoice_payment` int(11) DEFAULT NULL,
                            `billing_invoice_payment_text` varchar(255) DEFAULT NULL,

                            `billing_invoice_terms` int(11) DEFAULT NULL,
                            `billing_invoice_terms_text` varchar(255) DEFAULT NULL,

                            `billing_invoice_ship_type` int(11) DEFAULT NULL,
                            `billing_invoice_ship_text` varchar(255) DEFAULT NULL,
                            PRIMARY KEY (`billing_invoice_id`),
                            KEY `billing_invoice_created_by` (`billing_invoice_created_by`),
                            KEY `billing_invoice_client` (`billing_invoice_client`),
                            KEY `billing_invoice_referer` (`billing_invoice_referer`),
                            KEY `billing_invoice_reference` (`billing_invoice_reference`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'billing_invoice`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'billing_invoice_ibfk_1` FOREIGN KEY (`billing_invoice_created_by`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'billing_invoice_ibfk_2` FOREIGN KEY (`billing_invoice_client`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'billing_invoice_ibfk_3` FOREIGN KEY (`billing_invoice_referer`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'billing_invoice_ibfk_4` FOREIGN KEY (`billing_invoice_reference`) REFERENCES `' . $dbPool->get()->prefix . 'billing_invoice` (`billing_invoice_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'billing_element` (
                            `billing_element_id` int(11) NOT NULL AUTO_INCREMENT,
                            `billing_element_order` smallint(5) NOT NULL,
                            `billing_element_item` int(11) NOT NULL,
                            `billing_element_item_name` varchar(30) NOT NULL,
                            `billing_element_item_desc` text NOT NULL,
                            `billing_element_quantity` int(11) NOT NULL,
                            `billing_element_purchase_price` int(11) NOT NULL,
                            `billing_element_price_single` int(11) NOT NULL,
                            `billing_element_price_total` int(11) NOT NULL,
                            `billing_element_price_discount_single` int(11) NOT NULL,
                            `billing_element_price_discount_total` int(11) NOT NULL,
                            `billing_element_percentage_discount_single` int(11) NOT NULL,
                            `billing_element_percentage_discount_total` int(11) NOT NULL,
                            `billing_element_quantity_discount` int(11) NOT NULL,
                            `billing_element_price_single_net` int(11) NOT NULL,
                            `billing_element_price_total_net` int(11) NOT NULL,
                            `billing_element_tax_price` int(11) NOT NULL,
                            `billing_element_tax_percentage` int(11) NOT NULL,
                            `billing_element_price_single_gross` int(11) NOT NULL,
                            `billing_element_price_total_gross` int(11) NOT NULL,
                            `billing_element_invoice` int(11) NOT NULL,
                            `billing_element_promotion` int(11) DEFAULT NULL,
                            `billing_element_event` int(11) DEFAULT NULL,
                            PRIMARY KEY (`billing_element_id`),
                            KEY `billing_element_invoice` (`billing_element_invoice`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'billing_element`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'billing_element_ibfk_1` FOREIGN KEY (`billing_element_invoice`) REFERENCES `' . $dbPool->get()->prefix . 'billing_invoice` (`billing_invoice_id`);'
                )->execute();
                break;
        }
    }
}
