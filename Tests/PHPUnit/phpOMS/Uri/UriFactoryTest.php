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

namespace Tests\PHPUnit\phpOMS\Uri;

use phpOMS\Uri\UriFactory;
use phpOMS\Uri\Http;

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';

class UriFactoryTest extends \PHPUnit\Framework\TestCase
{

    public function testDefault()
    {
        self::assertNull(UriFactory::getQuery('Invalid'));
    }

    public function testSetGet()
    {
        self::assertTrue(UriFactory::setQuery('Valid', 'query1'));
        self::assertEquals('query1', UriFactory::getQuery('Valid'));

        self::assertTrue(UriFactory::setQuery('Valid', 'query2', true));
        self::assertEquals('query2', UriFactory::getQuery('Valid'));

        self::assertFalse(UriFactory::setQuery('Valid', 'query3', false));
        self::assertEquals('query2', UriFactory::getQuery('Valid'));

        self::assertTrue(UriFactory::setQuery('/valid2', 'query4'));
        self::assertEquals('query4', UriFactory::getQuery('/valid2'));
    }

    public function testClearing()
    {
        self::assertTrue(UriFactory::clear('Valid'));
        self::assertFalse(UriFactory::clear('Valid'));
        self::assertNull(UriFactory::getQuery('Valid'));
        self::assertEquals('query4', UriFactory::getQuery('/valid2'));

        self::assertTrue(UriFactory::clearAll());
        self::assertNull(UriFactory::getQuery('/valid2'));

        self::assertTrue(UriFactory::setQuery('/abc', 'query1'));
        self::assertTrue(UriFactory::setQuery('/valid2', 'query2'));
        self::assertTrue(UriFactory::setQuery('/valid3', 'query3'));
        self::assertFalse(UriFactory::clearLike('\d+'));
        self::assertTrue(UriFactory::clearLike('\/[a-z]*\d'));
        self::assertNull(UriFactory::getQuery('/valid2'));
        self::assertNull(UriFactory::getQuery('/valid3'));
        self::assertEquals('query1', UriFactory::getQuery('/abc'));
    }

    public function testBuilder()
    {
        $uri = 'www.test-uri.com?id={@ID}&test={.mTest}&two={/path}&hash={#hash}&none=#none&found={/not}&v={/valid2}';

        $vars = [
            '@ID'    => 1,
            '.mTest' => 'someString',
            '/path'  => 'PATH',
            '#hash'  => 'test',
        ];

        self::assertTrue(UriFactory::setQuery('/valid2', 'query4'));

        $expected = 'www.test-uri.com?id=1&test=someString&two=PATH&hash=test&none=#none&found=/not&v=query4';

        self::assertEquals($expected, UriFactory::build($uri, $vars));
    }

    public function testSetup()
    {
        $uri = 'http://www.test-uri.com/path/here?id=123&ab=c#fragi';

        UriFactory::setupUriBuilder(new Http($uri));

        self::assertEquals($uri, UriFactory::build('{/base}{/rootPath}{/}?id={?id}&ab={?ab}#{#}'));
        self::assertEquals($uri, UriFactory::build('{/scheme}://{/host}{/rootPath}{/}?id={?id}&ab={?ab}#{#}'));
        self::assertEquals($uri, UriFactory::build('{%}'));
        self::assertEquals($uri, UriFactory::build('{/base}{/rootPath}{/}?{?}#{#}'));
    }
}
