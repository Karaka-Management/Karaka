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
namespace Modules\Auditor\Models;

class Audit
{
    private $id = 0;

    private $type = 0;

    private $subtype = 0;

    private $module = null;

    private $ref = '';

    private $content = '';

    private $old = '';

    private $new = '';

    private $createdBy = 0;

    private $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new DateTime('now');
    }

    public function setType(int $type) /* : void */
    {
        $this->type = $type;
    }

    public function getType() : int
    {
        return $this->type;
    }

    public function setSubType(int $subtype) /* : void */
    {
        $this->subtype = $subtype;
    }

    public function getSubType() : int
    {
        return $this->subtype;
    }

    public function setModule(int $module) /* : void */
    {
        $this->module = $module;
    }

    public function getModule() : int
    {
        return $this->module;
    }

    public function setRef(string $ref) /* : void */
    {
        $this->ref = $ref;
    }

    public function getRef() : string
    {
        return $this->ref;
    }

    public function setContent(string $content) /* : void */
    {
        $this->content = $content;
    }

    public function getContent() : string
    {
        return $this->content;
    }

    public function setOld(string $old) /* : void */
    {
        $this->old = $old;
    }

    public function getOld() : string
    {
        return $this->old;
    }

    public function setNew(string $new) /* : void */
    {
        $this->new = $new;
    }

    public function getNew() : string
    {
        return $this->new;
    }

    public function setCreatedBy($createdBy) /* : void */
    {
        $this->createdBy = $createdBy;
    }

    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    public function getCreatedAt() : \DateTime
    {
        return $this->createdAt;
    }
}
