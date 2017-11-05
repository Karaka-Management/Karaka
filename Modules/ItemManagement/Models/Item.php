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
namespace Modules\ItemManagement\Models;

use Modules\Media\Models\Media;

/**
 * Account class.
 *
 * @category   Modules
 * @package    Modules\Admin
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Item
{
    private $id = 0;

    private $number = 0;

    private $articleGroup = 0;

    private $salesGroup = 0;

    private $productGroup = 0;

    private $segment = 0;

    private $successor = 0;

    private $media = [];

    private $l11n = null;

    private $attributes = [];

    private $partslist = null;

    private $purchase = [];

    private $disposal = null;

    private $createdAt = null;

    private $info = '';

    public function __construct()
    {
        $this->createdAt = new \DateTime('now');
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function getCreatedAt() : \DateTime
    {
        return $this->createdAt;
    }

    public function getNumber() : int
    {
        return $this->number;
    }

    public function setNumber(int $number) /* : void */
    {
        $this->number = $number;
    }

    public function getArticleGroup() : int
    {
        return $this->articleGroup;
    }

    public function setArticleGroup(int $segment) /* : void */
    {
        $this->articleGroup = $segment;
    }

    public function getSalesGroup() : int
    {
        return $this->salesGroup;
    }

    public function setSalesGroup(int $segment) /* : void */
    {
        $this->salesGroup = $segment;
    }

    public function getProductGroup() : int
    {
        return $this->productGroup;
    }

    public function setProductGroup(int $segment) /* : void */
    {
        $this->productGroup = $segment;
    }

    public function getSegment() : int
    {
        return $this->segment;
    }

    public function setSegment(int $segment) /* : void */
    {
        $this->segment = $segment;
    }

    public function getSuccessor() : int
    {
        return $this->successor;
    }

    public function setSuccessor(int $successor) /* : void */
    {
        $this->successor = $successor;
    }

    public function getMedia() : array
    {
        return $this->media;
    }

    public function addMedia(Media $media) /* : void */
    {
        $this->media[] = $media;
    }

    public function getInfo() : string
    {
        return $this->info;
    }

    public function setInfo(string $info) /* : void */
    {
        $this->info = $info;
    }
}
