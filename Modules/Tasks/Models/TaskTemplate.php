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
namespace Modules\Tasks\Models;

/**
 * Task class.
 *
 * @category   Modules
 * @package    Tasks
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class TaskTemplate extends Task
{
    /**
     * Type.
     *
     * @var TaskType
     * @since 1.0.0
     */
    protected $type = TaskType::TEMPLATE;
}
