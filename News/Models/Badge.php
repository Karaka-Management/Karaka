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
namespace Modules\News\Models;

/**
 * News article class.
 *
 * @category   Module
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Badge
{
    private $id = 0;

    private $name = '';

    public function __construct()
    {

    }

    public function getId() : int
    {
        return $this->id;
    }

    public function setName(string $name) /* : void */
    {
        $this->name = $name;
    }

    public function getName() : string
    {
        return $this->name;
    }
}