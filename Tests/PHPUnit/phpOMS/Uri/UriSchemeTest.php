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

namespace Tests\PHPUnit\phpOMS\Uri;

require_once __DIR__ . '/../../../../phpOMS/Autoloader.php';

use phpOMS\Uri\UriScheme;

class UriSchemeTest extends \PHPUnit\Framework\TestCase
{
    public function testEnum()
    {
        self::assertTrue(defined('phpOMS\Uri\UriScheme::HTTP'));
        self::assertTrue(defined('phpOMS\Uri\UriScheme::FILE'));
        self::assertTrue(defined('phpOMS\Uri\UriScheme::MAILTO'));
        self::assertTrue(defined('phpOMS\Uri\UriScheme::FTP'));
        self::assertTrue(defined('phpOMS\Uri\UriScheme::HTTPS'));
        self::assertTrue(defined('phpOMS\Uri\UriScheme::IRC'));
        self::assertTrue(defined('phpOMS\Uri\UriScheme::TEL'));
        self::assertTrue(defined('phpOMS\Uri\UriScheme::TELNET'));
        self::assertTrue(defined('phpOMS\Uri\UriScheme::SSH'));
        self::assertTrue(defined('phpOMS\Uri\UriScheme::SKYPE'));
        self::assertTrue(defined('phpOMS\Uri\UriScheme::SSL'));
        self::assertTrue(defined('phpOMS\Uri\UriScheme::NFS'));
        self::assertTrue(defined('phpOMS\Uri\UriScheme::GEO'));
        self::assertTrue(defined('phpOMS\Uri\UriScheme::MARKET'));
        self::assertTrue(defined('phpOMS\Uri\UriScheme::ITMS'));
    }

    public function testEnumUnique()
    {
        $values = UriScheme::getConstants();
        self::assertEquals(count($values), array_sum(array_count_values($values)));
    }
}
