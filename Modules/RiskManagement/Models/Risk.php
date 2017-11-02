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
namespace Modules\RiskManagement\Models;

/**
 * Risk Management class.
 *
 * @category   Modules
 * @package    Modules\RiskManagement
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Risk
{
    private $id = 0;

    private $name = '';

    private $description = '';

    private $descriptionRaw = '';

    private $unit = 1;

    private $department = null;

    private $category = null;

    private $project = null;

    private $process = null;

    private $responsible = null;

    private $deputy = null;

    private $histScore = [];

    private $causes = [];

    private $solutions = [];

    private $riskObjects = [];

    private $media = [];

    public function __construct()
    {
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function addCause($cause) /* : void */
    {
        $this->causes[] = $cause;
    }

    public function getCauses() : array
    {
        return $this->causes;
    }

    public function addSolution($solution) /* : solution */
    {
        $this->solutions[] = $solution;
    }

    public function getSolutions() : array
    {
        return $this->solutions;
    }

    public function getMedia() : array
    {
        return $this->media;
    }

    public function addMedia($media) /* : void */
    {
        $this->media[] = $media;
    }

    public function addRiskObject($object) /* : void */
    {
        $this->riskObjects[] = $object;
    }

    public function getRiskObjects() : array
    {
        return $this->riskObjects;
    }

    public function addHistory($history) /* : void */
    {
        $this->histScore[] = $history;
    }

    public function getHistory() : array
    {
        return $this->histScore;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function setName(string $name) /* : void */
    {
        $this->name = $name;
    }

    public function getDescription() : string
    {
        return $this->description;
    }

    public function setDescriptionRaw(string $description) /* : void */
    {
        $this->descriptionRaw = $description;
    }

    public function getDescriptionRaw() : string
    {
        return $this->descriptionRaw;
    }

    public function getUnit() 
    {
        return $this->unit;
    }

    public function setUnit($unit) /* : void */
    {
        $this->unit = $unit;
    }

    public function getDepartment()
    {
        return $this->department;
    }

    public function setDepartment($department) /* : void */
    {
        $this->department = $department;
    }

    public function getCategory() 
    {
        return $this->category;
    }

    public function setCategory($category) /* : void */
    {
        $this->category = $category;
    }

    public function getProject() 
    {
        return $this->project;
    }

    public function setProject($project) /* : void */
    {
        $this->project = $project;
    }

    public function getProcess() 
    {
        return $this->process;
    }

    public function setProcess($process) /* : void */
    {
        $this->process = $process;
    }

    public function getResponsible() 
    {
        return $this->responsible;
    }

    public function setResponsible($responsible) /* : void */
    {
        $this->responsible = $responsible;
    }

    public function getDeputy() 
    {
        return $this->deputy;
    }

    public function setDeputy($deputy) /* : void */
    {
        $this->deputy = $deputy;
    }
}