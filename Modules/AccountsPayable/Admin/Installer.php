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
namespace Modules\AccountsPayable\Admin;

use phpOMS\DataStorage\Database\DatabaseType;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Module\InfoManager;
use phpOMS\Module\InstallerAbstract;

/**
 * Accounts payable install class.
 *
 * @category   Modules
 * @package    Modules\AccountsPayable
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
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'accounts_payable` (
                            `accounts_payable_id` int(11) NOT NULL AUTO_INCREMENT,
                            `accounts_payable_account` int(11) DEFAULT NULL,
                            PRIMARY KEY (`accounts_payable_id`),
                            KEY `accounts_payable_account` (`accounts_payable_account`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'accounts_payable`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'accounts_payable_ibfk_1` FOREIGN KEY (`accounts_payable_account`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'accounts_payable_payment` (
                            `accounts_payable_payment_id` int(11) NOT NULL AUTO_INCREMENT,
                            `accounts_payable_payment_account` int(11) DEFAULT NULL,
                            `accounts_payable_payment_info` int(11) DEFAULT NULL,
                            PRIMARY KEY (`accounts_payable_payment_id`),
                            KEY `accounts_payable_payment_account` (`accounts_payable_payment_account`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'accounts_payable_payment`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'accounts_payable_payment_ibfk_1` FOREIGN KEY (`accounts_payable_payment_account`) REFERENCES `' . $dbPool->get()->prefix . 'accounts_payable` (`accounts_payable_id`);'
                )->execute();
                break;
        }
    }
}
