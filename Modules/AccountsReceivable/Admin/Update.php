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

use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Module\UpdateAbstract;
use phpOMS\System\File\Directory;
use phpOMS\Module\InfoManager;


/**
 * Navigation class.
 *
 * @category   Modules
 * @package    Modules\Admin
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Update extends UpdateAbstract
{

    /**
     * {@inheritdoc}
     */
    public static function update(DatabasePool $dbPool, InfoManager $info)
    {
        Directory::deletePath(__DIR__ . '/Update');
        mkdir('Update');
        parent::update($dbPool, $info);
    }
}
