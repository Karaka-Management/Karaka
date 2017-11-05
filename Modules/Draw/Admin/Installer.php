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
namespace Modules\Draw\Admin;

use phpOMS\DataStorage\Database\DatabaseType;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Module\InfoManager;
use phpOMS\Module\InstallerAbstract;

/**
 * Calendar install class.
 *
 * @category   Modules
 * @package    Modules\Calendar
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
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'draw_image` (
                            `draw_image_id` int(11) NOT NULL AUTO_INCREMENT,
                            `draw_image_media` int(11) NOT NULL,
                            `draw_image_path` varchar(255) NOT NULL,
                            PRIMARY KEY (`draw_image_id`),
                            KEY `draw_image_media` (`draw_image_media`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'draw_image`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'draw_image_ibfk_1` FOREIGN KEY (`draw_image_media`) REFERENCES `' . $dbPool->get()->prefix . 'media` (`media_id`);'
                )->execute();

                $dbPool->get()->con->prepare(
                    'CREATE TABLE if NOT EXISTS `' . $dbPool->get()->prefix . 'editor_tag` (
                            `editor_tag_id` int(11) NOT NULL AUTO_INCREMENT,
                            `editor_tag_doc` int(11) NOT NULL,
                            `editor_tag_tag` varchar(20) NOT NULL,
                            PRIMARY KEY (`editor_tag_id`),
                            KEY `editor_tag_doc` (`editor_tag_doc`)
                        )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;'
                )->execute();

                $dbPool->get()->con->prepare(
                    'ALTER TABLE `' . $dbPool->get()->prefix . 'editor_tag`
                            ADD CONSTRAINT `' . $dbPool->get()->prefix . 'editor_tag_ibfk_1` FOREIGN KEY (`editor_tag_doc`) REFERENCES `' . $dbPool->get()->prefix . 'draw_image` (`draw_image_id`);'
                )->execute();
                break;
        }
    }
}
