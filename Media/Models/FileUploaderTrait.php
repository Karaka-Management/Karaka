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
namespace Modules\Media\Models;

use phpOMS\Asset\AssetType;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;

/**
 * Options trait.
 *
 * @category   Framework
 * @package    phpOMS\Config
 * @since      1.0.0
 */
trait FileUploaderTrait
{

    /**
     * Setup file uploader.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Misc. data
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setUpFileUploader(RequestAbstract $request, ResponseAbstract $response, $data = null)
    {
        $head = $response->getHead();
        $head->addAsset(AssetType::JS, $request->getUri()->getBase() . 'Modules/Media/ModuleMedia.js');
    }
}
