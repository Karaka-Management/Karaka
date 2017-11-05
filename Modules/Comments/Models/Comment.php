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
namespace Modules\Comments\Models;

/**
 * Task class.
 *
 * @category   Comments
 * @package    Modules
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Comment
{
    private $id = 0;

    private $createdBy = 0;

    private $createdAt = null;

    private $list = null;

    private $title = '';

    private $content = '';

    private $ref = null;

    public function __construct() 
    {
        $this->createdAt = new \DateTime();
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function setRef($ref)
    {
        $this->ref = $ref;
    }

    public function getRef()
    {
        return $this->ref;
    }

    public function setList($list)
    {
        $this->list = $list;
    }

    public function getList()
    {
        return $this->list;
    }

    public function getTitle() : string
    {
        return $this->title;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    public function getContent() : string
    {
        return $this->content;
    }

    public function setContent(string $content)
    {
        $this->content = $content;
    }

    public function getCreatedBy() 
    {
        return $this->createdBy;
    }

    public function setCreatedBy($createdBy) 
    {
        $this->createdBy = $createdBy;
    }

    public function getCreatedAt() : \DateTime
    {
        return $this->createdAt;
    }
}