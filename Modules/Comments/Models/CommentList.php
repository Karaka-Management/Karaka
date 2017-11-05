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
class CommentList
{
    private $id = 0;

    private $comments = [];

    public function __construct() 
    {
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function getComments() : array
    {
        return $this->comments;
    }

    public function addComment($comment) 
    {
        $this->comments[] = $comment;
    }

}