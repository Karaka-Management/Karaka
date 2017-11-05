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
namespace Modules\Profile\Models;

/**
 * Account class.
 *
 * @category   Modules
 * @package    Modules\Admin
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class ContactElement
{
    private $id = 0;

    private $type = 0;

    private $subtype = 0;

    private $value = '';

    private $description = '';

    public function __construct()
    {
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function setType(int $type) /* : void */
    {
        $this->type = $type;
    }

    public function getType() : int
    {
        return $this->type;
    }

    public function setSubtype(int $type) /* : void */
    {
        $this->subtype = $type;
    }

    public function getSubtype() : int
    {
        return $this->subtype;
    }

    public function getValue() : string
    {
        return $this->value;
    }

    public function setValue(string $value) /* : void */
    {
        $this->value = $value;
    }

    public function getDescription() : string
    {
        return $this->description;
    }

    public function setDescription(string $description) /* : void */
    {
        $this->description = $description;
    }
}
