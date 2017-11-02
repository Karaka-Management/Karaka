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
namespace Modules\Job\Admin;

use phpOMS\DataStorage\Database\DatabaseType;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Module\InfoManager;
use phpOMS\Module\InstallerAbstract;

/**
 * Tasks install class.
 *
 * @category   Modules
 * @package    Modules\Tasks
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
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'job` (
                            `job_id` int(11) NOT NULL AUTO_INCREMENT,
                            `job_name` varchar(50) NOT NULL,
                            `job_status` int(11) NOT NULL,
                            `job_desc` varchar(100) DEFAULT NULL,
                            `job_created` datetime DEFAULT NULL,
                            `job_created_by` int(11) DEFAULT NULL,
                            PRIMARY KEY (`job_id`),
                            KEY `job_created_by` (`job_created_by`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'job`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'job_ibfk_1` FOREIGN KEY (`job_created_by`) REFERENCES `' . $dbPool->get()->prefix . 'account` (`account_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'job_log` (
                            `job_log_id` int(11) NOT NULL AUTO_INCREMENT,
                            `job_log_status` int(3) NOT NULL,
                            `job_log_message` text NOT NULL,
                            `job_log_job` int(11) NOT NULL,
                            `job_log_created` datetime DEFAULT NULL,
                            PRIMARY KEY (`job_log_id`),
                            KEY `job_log_job` (`job_log_job`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'job_log`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'job_log_ibfk_1` FOREIGN KEY (`job_log_job`) REFERENCES `' . $dbPool->get()->prefix . 'job` (`job_id`);'
                )->execute();

                break;
        }
    }
}
