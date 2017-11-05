<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   Framework
 * @package    phpOMS\Asset
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
declare(strict_types = 1);

namespace phpOMS\Asset;

use phpOMS\Stdlib\Base\Enum;

/**
 * Asset types enum.
 *
 * @category   Framework
 * @package    phpOMS\Asset
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
abstract class AssetType extends Enum
{
    /* public */ const CSS    = 0;
    /* public */ const JS     = 1;
    /* public */ const JSLATE = 2;
}
