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
namespace Modules\Profile\Admin;

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
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'profile_account` (
                            `profile_account_id` int(11) NOT NULL AUTO_INCREMENT,
                            `profile_account_image` int(11) DEFAULT NULL,
                            `profile_account_birthday` datetime DEFAULT NULL,
                            `profile_account_account` int(11) NOT NULL,
                            `profile_account_calendar` int(11) NOT NULL,
                            PRIMARY KEY (`profile_account_id`),
                            KEY `profile_account_image` (`profile_account_image`),
                            KEY `profile_account_account` (`profile_account_account`),
                            KEY `profile_account_calendar` (`profile_account_calendar`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'profile_account`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'profile_account_ibfk_1` FOREIGN KEY (`profile_account_image`) REFERENCES `' . $dbPool->get()->prefix . 'media` (`media_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'profile_account_ibfk_2` FOREIGN KEY (`profile_account_account`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`),
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'profile_account_ibfk_3` FOREIGN KEY (`profile_account_calendar`) REFERENCES `' . $dbPool->get()->prefix . 'calendar` (`calendar_id`);'
                )->execute();

                // real contacts that you also save in your email contact list. this is to store other accounts
                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'profile_contact` (
                            `profile_contact_id` int(11) NOT NULL AUTO_INCREMENT,
                            `profile_contact_name1` varchar(250) NOT NULL,
                            `profile_contact_name2` varchar(250) NOT NULL,
                            `profile_contact_name3` varchar(250) NOT NULL,
                            `profile_contact_company` varchar(250) NOT NULL,
                            `profile_contact_company_job` varchar(250) NOT NULL,
                            `profile_contact_address` varchar(250) NOT NULL,
                            `profile_contact_website` varchar(250) NOT NULL,
                            `profile_contact_birthday` datetime NOT NULL,
                            `profile_contact_description` text NOT NULL,
                            `profile_contact_account` int(11) NOT NULL,
                            PRIMARY KEY (`profile_contact_id`),
                            KEY `profile_contact_account` (`profile_contact_account`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'profile_contact`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'profile_contact_ibfk_1` FOREIGN KEY (`profile_contact_account`) REFERENCES `' . $dbPool->get()->prefix . 'profile_account` (`profile_account_id`);'
                )->execute();

                // email, phone etc for profile_contact
                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'profile_contact_element` (
                            `profile_contact_element_id` int(11) NOT NULL AUTO_INCREMENT,
                            `profile_contact_element_type` tinyint(2) NOT NULL,
                            `profile_contact_element_subtype` tinyint(2) NOT NULL,
                            `profile_contact_element_content` varchar(50) NOT NULL,
                            `profile_contact_element_contact` int(11) NOT NULL,
                            PRIMARY KEY (`profile_contact_element_id`),
                            KEY `profile_contact_element_contact` (`profile_contact_element_contact`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'profile_contact_element`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'profile_contact_element_ibfk_1` FOREIGN KEY (`profile_contact_element_contact`) REFERENCES `' . $dbPool->get()->prefix . 'profile_contact` (`profile_contact_id`);'
                )->execute();

                // not a full contact only the element like email, phone etc. for the accounts themselves (not profile_account)
                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'profile_contactelement` (
                            `profile_contactelement_id` int(11) NOT NULL AUTO_INCREMENT,
                            `profile_contactelement_type` tinyint(2) NOT NULL,
                            `profile_contactelement_subtype` tinyint(2) NOT NULL,
                            `profile_contactelement_content` varchar(50) NOT NULL,
                            `profile_contactelement_account` int(11) NOT NULL,
                            PRIMARY KEY (`profile_contactelement_id`),
                            KEY `profile_contactelement_account` (`profile_contactelement_account`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'profile_contactelement`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'profile_contactelement_ibfk_1` FOREIGN KEY (`profile_contactelement_account`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'profile_address` (
                            `profile_address_id` int(11) NOT NULL AUTO_INCREMENT,
                            `profile_address_type` tinyint(2) NOT NULL,
                            `profile_address_address` varchar(255) NOT NULL,
                            `profile_address_street` varchar(255) NOT NULL,
                            `profile_address_city` varchar(255) NOT NULL,
                            `profile_address_zip` varchar(255) NOT NULL,
                            `profile_address_country` varchar(255) NOT NULL,
                            `profile_address_account` int(11) DEFAULT NULL,
                            PRIMARY KEY (`profile_address_id`),
                            KEY `profile_address_account` (`profile_address_account`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'profile_address`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'profile_address_ibfk_1` FOREIGN KEY (`profile_address_account`) REFERENCES `' . $dbPool->get()->prefix . 'profile_account` (`profile_account_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'profile_account_relation` (
                            `profile_account_relation_id` int(11) NOT NULL AUTO_INCREMENT,
                            `profile_account_relation_type` tinyint(2) NOT NULL,
                            `profile_account_relation_relation` int(11) DEFAULT NULL,
                            `profile_account_relation_account` int(11) DEFAULT NULL,
                            PRIMARY KEY (`profile_account_relation_id`),
                            KEY `profile_account_relation_account` (`profile_account_relation_account`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'profile_account_relation`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'profile_account_relation_ibfk_1` FOREIGN KEY (`profile_account_relation_account`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'profile_account_setting` (
                            `profile_account_setting_id` int(11) NOT NULL AUTO_INCREMENT,
                            `profile_account_setting_module` int(11) NOT NULL,
                            `profile_account_setting_type` varchar(20) NOT NULL,
                            `profile_account_setting_value` varchar(32) DEFAULT NULL,
                            `profile_account_setting_account` int(11) DEFAULT NULL,
                            PRIMARY KEY (`profile_account_setting_id`),
                            KEY `profile_account_setting_account` (`profile_account_setting_account`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'profile_account_setting`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'profile_account_setting_ibfk_1` FOREIGN KEY (`profile_account_setting_account`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`);'
                )->execute();
                break;
        }
    }
}
