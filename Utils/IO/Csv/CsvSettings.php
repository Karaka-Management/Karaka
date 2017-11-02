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

namespace phpOMS\Utils\IO\Csv;

/**
 * Options trait.
 *
 * @category   Framework
 * @package    phpOMS\Config
 * @since      1.0.0
 */
class CsvSettings
{
    /**
     * Get csv file delimiter.
     *
     * @param mixed $file       File resource
     * @param int   $checkLines Lines to check for evaluation
     * @param array $delimiters Potential delimiters
     *
     * @return string
     *
     * @since  1.0.0
     */
    public static function getFileDelimiter($file, int $checkLines = 2, array $delimiters = [',', '\t', ';', '|', ':']) : string
    {
        $results = [];

        $i = 0;
        while (($line = fgets($file)) !== false && $i < $checkLines) {
            $i++;

            foreach ($delimiters as $delimiter) {
                $regExp = '/[' . $delimiter . ']/';
                $fields = preg_split($regExp, $line);

                if (count($fields) > 1) {
                    if (!empty($results[$delimiter])) {
                        $results[$delimiter]++;
                    } else {
                        $results[$delimiter] = 1;
                    }
                }
            }
        }

        $results = array_keys($results, max($results));

        return $results[0];
    }
}
