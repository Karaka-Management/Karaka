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
namespace Modules\PaymentInformation\Admin;

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
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'payment_info` (
                            `payment_info_id` int(11) NOT NULL AUTO_INCREMENT,
                            `payment_info_account` int(11) DEFAULT NULL,
                            PRIMARY KEY (`payment_info_id`),
                            KEY `payment_info_account` (`payment_info_account`)
                        )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'payment_info`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'payment_info_ibfk_1` FOREIGN KEY (`payment_info_account`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`);'
                )->execute();
                break;
        }
    }
}
