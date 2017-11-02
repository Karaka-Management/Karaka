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

namespace phpOMS\Utils;

/**
 * String comparison class.
 *
 * This class helps to compare two strings
 *
 * @category   Framework
 * @package    phpOMS\Utils
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class StringCompare
{
    /**
     * Dictionary.
     *
     * @var array
     * @since 1.0.0
     */
    private $dictionary = [];

    /**
     * Constructor.
     * 
     * @param array $dictionary Dictionary
     *
     * @since  1.0.0
     */
    public function __construct(array $dictionary)
    {
        $this->dictionary = $dictionary;
    }

    /**
     * Adds word to dictionary
     * 
     * @param string $word Word to add to dictionary
     * 
     * @return void
     *
     * @since  1.0.0
     */
    public function add(string $word) /* : void */
    {
        $this->dictionary[] = $word;
    }

    /**
     * Match word against dictionary.
     *
     * @param string $match Word to match against dictionary
     *
     * @return string Best match
     *
     * @since  1.0.0
     */
    public function matchDictionary(string $match) : string
    {
        $bestScore = PHP_INT_MAX;
        $bestMatch = '';

        foreach ($this->dictionary as $word) {
            $score = self::fuzzyMatch($word, $match);

            if ($score < $bestScore) {
                $bestScore = $score;
                $bestMatch = $word;
            }
        }

        return $bestMatch;
    }

    /**
     * Calculate word match score.
     *
     * @param string $s1 Word 1
     * @param string $s2 Word 2
     *
     * @return int
     *
     * @since  1.0.0
     */
    public static function valueWords(string $s1, string $s2) : int
    {
        $words1 = preg_split('/[ _-]/', $s1);
        $words2 = preg_split('/[ _-]/', $s2);
        $total = 0;

        foreach ($words1 as $word1) {
            $best = strlen($s2);

            foreach ($words2 as $word2) {
                $wordDist = levenshtein($word1, $word2);

                if ($wordDist < $best) {
                    $best = $wordDist;
                }

                if ($wordDist === 0) {
                    break;
                }
            }

            $total += $total + $best;
        }

        return $total;
    }

    /**
     * Calculate phrase match score.
     *
     * @param string $s1 Word 1
     * @param string $s2 Word 2
     *
     * @return int
     *
     * @since  1.0.0
     */
    public static function valuePhrase(string $s1, string $s2) : int
    {
        return levenshtein($s1, $s2);
    }

    /**
     * Calculate word length score.
     *
     * @param string $s1 Word 1
     * @param string $s2 Word 2
     *
     * @return int
     *
     * @since  1.0.0
     */
    public static function valueLength(string $s1, string $s2) : int
    {
        return abs(strlen($s1) - strlen($s2));
    }

    /**
     * Calculate fuzzy match score.
     *
     * @param string $s1 Word 1
     * @param string $s2 Word 2
     * @param float $phraseWeight Weighting for phrase score
     * @param float $wordWeight Weighting for word score
     * @param float $minWeight Min weight
     * @param float $maxWeight Max weight
     * @param float $lengthWeight Weighting for word length
     *
     * @return float
     *
     * @since  1.0.0
     */
    public static function fuzzyMatch(string $s1, string $s2, float $phraseWeight = 0.5, float $wordWeight = 1, float $minWeight = 10, float $maxWeight = 1, float $lengthWeight = -0.3) : float
    {
        $phraseValue = self::valuePhrase($s1, $s2);
        $wordValue   = self::valueWords($s1, $s2);
        $lengthValue = self::valueLength($s1, $s2);

        return min($phraseValue * $phraseWeight, $wordValue * $wordWeight) * $minWeight
            + max($phraseValue * $phraseWeight, $wordValue * $wordWeight) * $maxWeight
            + $lengthValue * $lengthWeight;
    } 
}