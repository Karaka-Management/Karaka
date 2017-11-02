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
 * @link       http://orange-management.com
 */

namespace Tests\PHPUnit\Modules\RiskManagement\Models;

use Modules\RiskManagement\Models\Risk;
use Modules\RiskManagement\Models\RiskMapper;
use Modules\RiskManagement\Models\Cause;
use Modules\RiskManagement\Models\Solution;
use Modules\RiskManagement\Models\Category;
use Modules\RiskManagement\Models\Project;
use Modules\RiskManagement\Models\Process;
use Modules\RiskManagement\Models\RiskObject;
use Modules\Media\Models\Media;
use phpOMS\DataStorage\Database\DataMapperAbstract;
use phpOMS\DataStorage\Database\DatabasePool;

require_once __DIR__ . '/../../../../../phpOMS/Autoloader.php';
require_once __DIR__ . '/../../../../../config.php';

class RiskMapperTest extends \PHPUnit\Framework\TestCase
{

    public function testCRUD()
    {
        $obj = new Risk();

        $obj->setName('Risk Test');
        $obj->setDescriptionRaw('Description');
        $obj->setUnit(1);
        $obj->setDepartment(2);

        $categoryObj = new Category();
        $obj->setCategory($categoryObj);

        $processObj = new Process();
        $obj->setProcess($processObj);

        $projectObj = new Project();
        $projectObj->setProject(1);
        $obj->setProject($projectObj);

        $obj->setResponsible(1);
        $obj->setDeputy(1);

        $causeObj = new Cause();
        $causeObj->setTitle('Risk Test Cause');
        $obj->addCause($causeObj);

        $solutionObj = new Solution();
        $solutionObj->setTitle('Risk Test Solution');
        $obj->addSolution($solutionObj);

        $riskObj = new RiskObject();
        $riskObj->setTitle('Risk Test Object');
        $obj->addRiskObject($riskObj);

        $obj->addHistory(2);

        $media = new Media();
        $media->setCreatedBy(1);
        $media->setDescription('desc');
        $media->setPath('some/path');
        $media->setSize(11);
        $media->setExtension('png');
        $media->setName('Image');
        $obj->addMedia($media);

        RiskMapper::create($obj);

        $objR = RiskMapper::get($obj->getId());
        self::assertEquals($obj->getName(), $objR->getName());
        self::assertEquals($obj->getDescriptionRaw(), $objR->getDescriptionRaw());
        self::assertEquals($obj->getUnit(), $objR->getUnit()->getId());
        self::assertEquals($obj->getDepartment(), $objR->getDepartment()->getId());
        self::assertEquals($obj->getCategory()->getId(), $objR->getCategory()->getId());
        self::assertEquals($obj->getProcess()->getId(), $objR->getProcess()->getId());
        self::assertEquals($obj->getResponsible(), $objR->getResponsible());
        self::assertEquals($obj->getDeputy(), $objR->getDeputy());
        self::assertEquals($obj->getProject()->getProject(), $objR->getProject()->getProject()->getId());

        $causes = $objR->getCauses();
        self::assertEquals($obj->getCauses()[0]->getTitle(), end($causes)->getTitle());

        $solutions = $objR->getSolutions();
        self::assertEquals($obj->getSolutions()[0]->getTitle(), end($solutions)->getTitle());

        $riskObjects = $objR->getRiskObjects();
        self::assertEquals($obj->getRiskObjects()[0]->getTitle(), end($riskObjects)->getTitle());
        
        //self::assertEquals($obj->getHistory()[0], $objR->getHistory()[0]);
        $media = $objR->getMedia();
        self::assertEquals($obj->getMedia()[0]->getPath(), end($media)->getPath());
    }
}