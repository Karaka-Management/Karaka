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

use Modules\Admin\Models\Account;
use Modules\Admin\Models\NullAccount;
use Modules\Media\Models\Media;
use Modules\Media\Models\NullMedia;
use Modules\Calendar\Models\Calendar;

/**
 * Account class.
 *
 * @category   Modules
 * @package    Modules\Admin
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Profile
{
    private $id = 0;

    private $image = null;

    private $birthday = null;

    private $account = null;

    private $location = [];

    private $calendar = null;

    public function __construct() 
    {
        $this->image = new NullMedia();
        $this->birthday = new \DateTime('now');
        $this->account = new Account();
        $this->calendar = new Calendar();
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function getLocation() : array
    {
        return $this->location;
    }

    public function addLocation(Location $location) 
    {
        $this->location[] = $location;
    }

    public function getCalendar()
    {
        return $this->calendar;
    }

    public function getImage() : Media
    {
        return $this->image;
    }

    public function setImage(Media $image) /* : void */
    {
        $this->image = $image;
    }

    public function setAccount(Account $account) /* : void */
    {
        $this->account = $account;
    }

    public function getAccount() : Account
    {
        return $this->account ?? new NullAccount();
    }

    public function setBirthday(\DateTime $birthday) /* : void */
    {
        $this->birthday = $birthday;
    }

    public function getBirthday() : \DateTime
    {
        return $this->birthday;
    }
}
