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
namespace Modules\Draw\Models;

use Modules\Media\Models\Media;
use phpOMS\Contract\ArrayableInterface;

/**
 * News article class.
 *
 * @category   Module
 * @package    Framework
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class DrawImage implements ArrayableInterface, \JsonSerializable
{

    /**
     * Article ID.
     *
     * @var int
     * @since 1.0.0
     */
    private $id = 0;

    /**
     * Doc path for organizing.
     *
     * @var string
     * @since 1.0.0
     */
    private $path = '';

    /**
     * Media object.
     *
     * @var Media
     * @since 1.0.0
     */
    private $media = null;

    /**
     * Constructor.
     *
     * @since  1.0.0
     */
    public function __construct()
    {
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

    /**
     * @return string
     *
     * @since  1.0.0
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * @param string $media
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public function setMedia($media)
    {
        $this->media = $media;
    }

    public function toArray() : array
    {
        return [
            'id' => $this->id,
            'path' => $this->path,
            'media' => $this->media->toArray(),
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

    public static function fromMedia(Media $media)
    {
        $image = new self();
        $image->setMedia($media);

        return $image;
    }
}
