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
namespace Modules\SupplierManagement\Models;

use Modules\Media\Models\Media;
use Modules\Profile\Models\Profile;

/**
 * Account class.
 *
 * @category   Modules
 * @package    Modules\Admin
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Supplier
{
    private $id = 0;

    private $number = 0;

    private $numberReverse = 0;

    private $status = 0;

    private $type = 0;

    private $taxId = '';

    private $info = '';

    private $createdAt = null;

    private $profile = null;

    private $files = [];

    private $contactElements = [];

    private $address = [];

    public function __construct(int $id = 0)
    {
        $this->createdAt = new \DateTime('now');
        $this->profile   = new Profile();
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function getNumber() : int
    {
        return $this->number;
    }

    public function setNumber(int $number) /* : void */
    {
        $this->number = $number;
    }

    public function getReverseNumber()
    {
        return $this->numberReverse;
    }

    public function setReverseNumber($rev_no) /* : void */
    {
        if (!is_scalar($rev_no)) {
            throw new \Exception();
        }

        $this->numberReverse = $rev_no;
    }

    public function getStatus() : int
    {
        return $this->status;
    }

    public function setStatus(int $status) /* : void */
    {
        $this->status = $status;
    }

    public function getType() : int
    {
        return $this->type;
    }

    public function setType(int $type) /* : void */
    {
        $this->type = $type;
    }

    public function getTaxId() : string
    {
        return $this->taxId;
    }

    public function setTaxId(string $taxId) /* : void */
    {
        $this->taxId = $taxId;
    }

    public function getInfo() : string
    {
        return $this->info;
    }

    public function setInfo(string $info)  /* : void */
    {
        $this->info = $info;
    }

    public function getCreatedAt() : \DateTime
    {
        return $this->createdAt;
    }

    public function getProfile() : Profile
    {
        return $this->profile;
    }

    public function setProfile(Profile $profile) /* : void */
    {
        $this->profile = $profile;
    }

    public function getFiles() : array
    {
        return $this->files;
    }

    public function addFile(Media $file) /* : void */
    {
        $this->files[] = $file;
    }

    public function getAddresses() : array
    {
        return $this->address;
    }

    public function getContactElements() : array
    {
        return $this->contactElements;
    }
}
