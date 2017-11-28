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
namespace Modules\News\Models;

use phpOMS\Contract\ArrayableInterface;
use phpOMS\Stdlib\Base\Exception\InvalidEnumValue;
use phpOMS\Localization\ISO639x1Enum;

/**
 * News article class.
 *
 * @category   Module
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class NewsArticle implements ArrayableInterface, \JsonSerializable
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
     * News type.
     *
     * @var int
     * @since 1.0.0
     */
    private $type = NewsType::ARTICLE;

    /**
     * News status.
     *
     * @var int
     * @since 1.0.0
     */
    private $status = NewsStatus::DRAFT;

    /**
     * Language.
     *
     * @var string
     * @since 1.0.0
     */
    private $language = ISO639x1Enum::_EN;

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
     * Publish.
     *
     * @var \DateTime
     * @since 1.0.0
     */
    private $publish = null;

    /**
     * Featured.
     *
     * @var bool
     * @since 1.0.0
     */
    private $featured = false;

    /**
     * Badge.
     *
     * @var array
     * @since 1.0.0
     */
    private $badges = [];

    /**
     * Constructor.
     *
     * @since  1.0.0
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
        $this->publish = new \DateTime('now');
    }

    public function getBadges() : array
    {
        return $this->badges;
    }

    public function addBadge(Badge $badge) /* : void */
    {
        $this->badges[] = $badge;
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
     * @return string
     *
     * @since  1.0.0
     */
    public function getLanguage() : string
    {
        return $this->language;
    }

    /**
     * @return \DateTime
     *
     * @since  1.0.0
     */
    public function getPublish() : \DateTime
    {
        return $this->publish;
    }

    /**
     * @param string $language
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setLanguage(string $language)
    {
        if (!ISO639x1Enum::isValidValue($language)) {
            throw new InvalidEnumValue($language);
        }

        $this->language = $language;
    }

    /**
     * @param \DateTime $publish
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setPublish(\DateTime $publish)
    {
        $this->publish = $publish;
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
     * @return int
     *
     * @since  1.0.0
     */
    public function getType() : int
    {
        return $this->type;
    }

    /**
     * @param int $type
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setType(int $type)
    {
        if (!NewsType::isValidValue($type)) {
            throw new InvalidEnumValue((string) $type);
        }

        $this->type = $type;
    }

    /**
     * @return int
     *
     * @since  1.0.0
     */
    public function getStatus() : int
    {
        return $this->status;
    }

    /**
     * @param int $status
     *
     * @return void
     *
     * @throws InvalidEnumValue
     *
     * @since  1.0.0
     */
    public function setStatus(int $status)
    {
        if (!NewsStatus::isValidValue($status)) {
            throw new InvalidEnumValue((string) $status);
        }

        $this->status = $status;
    }

    /**
     * @return bool
     *
     * @since  1.0.0
     */
    public function isFeatured() : bool
    {
        return $this->featured;
    }

    /**
     * @param bool $featured
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setFeatured(bool $featured)
    {
        $this->featured = $featured;
    }

    public function toArray() : array 
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'plain' => $this->plain,
            'content' => $this->content,
            'type' => $this->type,
            'status' => $this->status,
            'featured' => $this->featured,
            'publish' => $this->publish->format('Y-m-d H:i:s'),
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
