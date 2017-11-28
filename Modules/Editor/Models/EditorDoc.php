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
namespace Modules\Editor\Models;

use phpOMS\Contract\ArrayableInterface;

/**
 * News article class.
 *
 * @category   Module
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class EditorDoc implements ArrayableInterface, \JsonSerializable
{

    /**
     * Article ID.
     *
     * @var int
     * @since 1.0.0
     */
    private $id = 0;

    /**
     * Title.
     *
     * @var string
     * @since 1.0.0
     */
    private $title = '';

    /**
     * Content.
     *
     * @var string
     * @since 1.0.0
     */
    private $content = '';

    /**
     * Unparsed.
     *
     * @var string
     * @since 1.0.0
     */
    private $plain = '';

    /**
     * Doc path for organizing.
     *
     * @var string
     * @since 1.0.0
     */
    private $path = '';

    /**
     * Created.
     *
     * @var \DateTime
     * @since 1.0.0
     */
    private $createdAt = null;

    /**
     * Creator.
     *
     * @var int
     * @since 1.0.0
     */
    private $createdBy = 0;

    /**
     * Constructor.
     *
     * @since  1.0.0
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime('NOW');
    }

    /**
     * @return string
     *
     * @since  1.0.0
     */
    public function getContent() : string
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setContent(string $content)
    {
        $this->content = $content;
    }

    /**
     * @param string $plain
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setPlain(string $plain)
    {
        $this->plain = $plain;
    }

    /**
     * @return string
     *
     * @since  1.0.0
     */
    public function getPlain() : string
    {
        return $this->plain;
    }

    /**
     * @return \DateTime
     *
     * @since  1.0.0
     */
    public function getCreatedAt() : \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return int
     *
     * @since  1.0.0
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * @return int
     *
     * @since  1.0.0
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param int $id
     *
     * @since  1.0.0
     */
    public function setCreatedBy($id)
    {
        $this->createdBy = $id;
    }

    /**
     * @return string
     *
     * @since  1.0.0
     */
    public function getTitle() : string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     *
     * @since  1.0.0
     */
    public function getPath() : string
    {
        return $this->path;
    }

    /**
     * @param string $path
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public function setPath(string $path)
    {
        $this->path = $path;
    }

    public function toArray() : array 
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'plain' => $this->plain,
            'content' => $this->content,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'createdBy' => $this->createdBy,
        ];
    }

    public function __toString() 
    {
        return json_encode($this->toArray());
    }

    public function jsonSerialize() 
    {
        return $this->toArray();
    }
}
