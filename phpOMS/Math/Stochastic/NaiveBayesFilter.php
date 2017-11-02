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
namespace phpOMS\Math\Stochastic;
/**
 * Bernulli distribution.
 *
 * @category   Framework
 * @package    phpOMS\DataStorage\Database
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class NaiveBayesFilter
{
    private $dict = [];
    
    public function __construct()
    {
    }
    
    public function trainMatch($matched) /* : void */
    {
    }
    
    public function trainMismatch($mismatch) /* : void */
    {
    }
    
    public function match($toMatch) : float
    {
        $normalizedDict = $this->normalizeDictionary();

        $n = 0.0;
        foreach ($toMatch as $element) {
            if (isset($normalizedDict[$element])) {
                $n += log(1 - $normalizedDict[$element]['match'] / $normalizedDict[$element]['total']) - log($normalizedDict[$element]['match'] / $normalizedDict[$element]['total']);
            }
        }
        
        return 1 / (1 + exp($n));
    }
    
    private function normalizeDictionary() : array
    {
        return $this->dict;
    }
}
