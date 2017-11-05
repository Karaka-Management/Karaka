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

namespace Tests\PHPUnit\phpOMS\Utils\Encoding\Huffman;

require_once __DIR__ . '/../../../../../../phpOMS/Autoloader.php';

use phpOMS\Utils\Encoding\Huffman\Dictionary;

class DictionaryTest extends \PHPUnit\Framework\TestCase
{
	/**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidGetCharacter()
    {
		$dict = new Dictionary();
		$dict->get('as');
	}

	/**
     * @expectedException \InvalidArgumentException
     */
    public function testNotExistingGetCharacter()
    {
		$dict = new Dictionary();
		$dict->get('a');
	}

	/**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidSetCharacter()
    {
		$dict = new Dictionary();
		$dict->set('as', 'test');
	}

	/**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidSetDuplicateCharacter()
    {
		$dict = new Dictionary();
		$dict->set('a', '1');
		$dict->set('a', '1');
	}

	/**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidFormattedValue()
    {
		$dict = new Dictionary();
		$dict->set('a', '1a');
	}
}
