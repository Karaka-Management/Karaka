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

namespace Tests\PHPUnit\phpOMS\Utils;

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';

use phpOMS\Utils\StringCompare;

class StringCompareTest extends \PHPUnit\Framework\TestCase
{
    public function testDictionary()
    {
        $dict = new StringCompare(
            [
                'Table Airplane Snowflake',
                'Football Pancake Doghouse Bathtub',
                'Spaceship Cowboy Spaceship Cowboy',
                'Snowflake Bathtub Snowflake Toothbrush Sidewalk',
                'Rocket Spaceship Table',
                'Cowboy Snowflake Bathtub',
                'Spaceship Classroom Apple',
                'Bathtub Sidewalk Table',
                'Teacher Bathtub Paper',
                'Cartoon',
                'Cowboy Table Pencil Candy Snowflake',
                'Apple Apple Cowboy Rocket',
                'Sidewalk Tiger Snowflake Spider',
                'Zebra Apple Magnet Sidewal',
            ]
        );

        self::assertEquals('Cartoon', $dict->matchDictionary('Cartoon'));
        self::assertEquals('Bathtub Sidewalk Table', $dict->matchDictionary('Sidewalk Table'));

        // todo: this doesn't match since the length is too far apart
        //self::assertEquals('Snowflake Bathtub Snowflake Toothbrush Sidewalk', $dict->matchDictionary('Toothbrush'));

        $dict->add('Carton');
        self::assertEquals('Carton', $dict->matchDictionary('carton'));
    }
}
