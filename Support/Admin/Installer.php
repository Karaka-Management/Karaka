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
namespace Modules\Support\Admin;

use phpOMS\DataStorage\Database\DatabaseType;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Module\InfoManager;
use phpOMS\Module\InstallerAbstract;

/**
 * Support install class.
 *
 * @category   Modules
 * @package    Modules\Support
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
            
                            $dbPool->get()->con->prepare(
                                'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'support_ticket` (
                                        `support_ticket_id` int(11) NOT NULL AUTO_INCREMENT,
                                        `support_ticket_task` int(11) DEFAULT NULL,
                                        PRIMARY KEY (`support_ticket_id`),
                                        KEY `support_ticket_task` (`support_ticket_task`)
                                    )ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                            )->execute();
            
                            $dbPool->get()->con->prepare(
                                'ALTER TABLE `' . $dbPool->get()->prefix . 'support_ticket`
                                        ADD CONSTRAINT `' . $dbPool->get()->prefix . 'support_ticket_ibfk_1` FOREIGN KEY (`support_ticket_task`) REFERENCES `' . $dbPool->get()->prefix . 'task` (`task_id`);'
                            )->execute();
                      
                            $dbPool->get()->con->commit();
                break;
        }
    }
}
