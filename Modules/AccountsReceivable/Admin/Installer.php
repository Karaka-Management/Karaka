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
namespace Modules\AccountsReceivable\Admin;

use phpOMS\DataStorage\Database\DatabaseType;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Module\InfoManager;
use phpOMS\Module\InstallerAbstract;

/**
 * Accounts receivable install class.
 *
 * @category   Modules
 * @package    Modules\AccountsReceivable
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
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'accounts_receivable` (
                            `accounts_receivable_id` int(11) NOT NULL AUTO_INCREMENT,
                            `accounts_receivable_account` int(11) NOT NULL,
                            PRIMARY KEY (`accounts_receivable_id`),
                            KEY `accounts_receivable_id` (`accounts_receivable_id`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'accounts_receivable`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'accounts_receivable_ibfk_1` FOREIGN KEY (`accounts_receivable_account`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'accounts_receivable_payment` (
                            `accounts_receivable_payment_id` int(11) NOT NULL AUTO_INCREMENT,
                            `accounts_receivable_payment_account` int(11) DEFAULT NULL,
                            `accounts_receivable_payment_info` int(11) DEFAULT NULL,
                            PRIMARY KEY (`accounts_receivable_payment_id`),
                            KEY `accounts_receivable_payment_account` (`accounts_receivable_payment_account`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'accounts_receivable_payment`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'accounts_receivable_payment_ibfk_1` FOREIGN KEY (`accounts_receivable_payment_account`) REFERENCES `' . $dbPool->get()->prefix . 'accounts_receivable` (`accounts_receivable_id`);'
                )->execute();
                break;
        }
    }
}
