<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   TBD
 * @package    TBD
 * @author     OMS Development Team <dev@oms.com>
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */

namespace Tests\PHPUnit\phpOMS\DataStorage\Database\TestModel;

require_once __DIR__ . '/../../../../../../phpOMS/Autoloader.php';

class BaseModel
{
    public $id = 0;
    
    public $string = 'Base';
    
    public $int = 11;
    
    public $bool = false;
    
    public $float = 1.3;
    
    public $null = null;
    
    public $datetime = null;
    
    public $hasManyDirect = [];

    public $hasManyRelations = [];

    public $ownsOneSelf = 0;

    public $belongsToOne = 0;
    
    public $serializable = null;
    
    public $json = [1, 2, 3];
    
    public $jsonSerializable = null;

    public function __construct()
    {
        $this->datetime = new \DateTime('2005-10-11');

        $this->hasManyDirect = [
            new ManyToManyDirectModel(),
            new ManyToManyDirectModel(),
        ];

        $this->hasManyRelations = [
            new ManyToManyRelModel(),
            new ManyToManyRelModel(),
        ];

        $this->ownsOneSelf = new OwnsOneModel();
        $this->belongsToOne = new BelongsToModel();

        $this->serializable = new class implements \Serializable {
            public function serialize() {
                return '123';
            }

            public function unserialize($data) {}
        };

        $this->jsonSerializable = new class implements \JsonSerializable {
            public function jsonSerialize() {
                return [1, 2, 3];
            }
        };
    }
}