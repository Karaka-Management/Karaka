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
 * @link       http://website.orange-management.de
 */
declare(strict_types = 1);
namespace Modules\Draw;

use Model\Message\FormValidation;
use Modules\Draw\Models\DrawImage;
use Modules\Draw\Models\DrawImageMapper;
use Modules\Draw\Models\PermissionState;
use Modules\Media\Models\UploadStatus;
use phpOMS\Asset\AssetType;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Model\Html\Head;
use phpOMS\Module\ModuleAbstract;
use phpOMS\Module\WebInterface;
use Modules\Media\Controller as MediaController;
use phpOMS\System\File\Local\File;
use phpOMS\Utils\ImageUtils;
use phpOMS\Views\View;
use phpOMS\Account\PermissionType;
use phpOMS\Message\Http\RequestStatusCode;

/**
 * Calendar controller class.
 *
 * @category   Modules
 * @package    Draw
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Controller extends ModuleAbstract implements WebInterface
{

    /**
     * Module path.
     *
     * @var string
     * @since 1.0.0
     */
    /* public */ const MODULE_PATH = __DIR__;

    /**
     * Module version.
     *
     * @var string
     * @since 1.0.0
     */
    /* public */ const MODULE_VERSION = '1.0.0';

    /**
     * Module name.
     *
     * @var string
     * @since 1.0.0
     */
    /* public */ const MODULE_NAME = 'Draw';

    /**
     * Module id.
     *
     * @var int
     * @since 1.0.0
     */
    /* public */ const MODULE_ID = 1005200000;

    /**
     * Providing.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $providing = [];

    /**
     * Dependencies.
     *
     * @var string
     * @since 1.0.0
     */
    protected static $dependencies = [
    ];

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return void
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function setUpDrawEditor(RequestAbstract $request, ResponseAbstract $response, $data = null)
    {
        /** @var Head $head */
        $head = $response->get('Content')->getData('head');
        $head->addAsset(AssetType::JSLATE, '/Modules/Draw/Controller.js');
        $head->addAsset(AssetType::JSLATE, '/Modules/Draw/Models/DrawType.enum.js');
        $head->addAsset(AssetType::JSLATE, '/Modules/Draw/Models/Editor.js');
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return \Serializable
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewDrawCreate(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);

        if (!$this->app->accountManager->get($request->getHeader()->getAccount())->hasPermission(
            PermissionType::CREATE, $this->app->orgId, $this->app->appName, self::MODULE_ID, PermissionState::DRAW)
        ) {
            $view->setTemplate('/Web/Backend/Error/403_inline');
            $response->getHeader()->setStatusCode(RequestStatusCode::R_403);
            return $view;
        }

        $view->setTemplate('/Modules/Draw/Theme/Backend/draw-create');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1005201001, $request, $response));

        return $view;
    }

    
    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return \Serializable
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewDrawSingle(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);

        $draw      = DrawImageMapper::get($request->getData('id'));
        $accountId = $request->getHeader()->getAccount();

        if ($draw->getCreatedBy()->getId() !== $accountId
            && !$this->app->accountManager->get($accountId)->hasPermission(
                PermissionType::READ, $this->app->orgId, $this->app->appName, self::MODULE_ID, PermissionState::DRAW, $draw->getId())
        ) {
            $view->setTemplate('/Web/Backend/Error/403_inline');
            $response->getHeader()->setStatusCode(RequestStatusCode::R_403);
            return $view;
        }

        $view->setTemplate('/Modules/Draw/Theme/Backend/draw-single');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1005201001, $request, $response));

        $view->addData('image', $draw);

        return $view;
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return \Serializable
     *
     * @since  1.0.0
     * @codeCoverageIgnore
     */
    public function viewDrawList(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);

        if (!$this->app->accountManager->get($request->getHeader()->getAccount())->hasPermission(
            PermissionType::READ, $this->app->orgId, $this->app->appName, self::MODULE_ID, PermissionState::DASHBOARD)
        ) {
            $view->setTemplate('/Web/Backend/Error/403_inline');
            $response->getHeader()->setStatusCode(RequestStatusCode::R_403);
            return $view;
        }

        $view->setTemplate('/Modules/Draw/Theme/Backend/draw-list');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1005201001, $request, $response));

        $images = DrawImageMapper::getNewest(25);
        $view->addData('images', $images);

        return $view;
    }

    private function validateDrawCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (
            ($val['title'] = empty($request->getData('title')))
            || ($val['image'] = empty($request->getData('image')))
        ) {
            return $val;
        }

        return [];
    }

    /**
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @since  1.0.0
     */
    public function apiDrawCreate(RequestAbstract $request, ResponseAbstract $response, $data = null)
    {
        if (!$this->app->accountManager->get($request->getHeader()->getAccount())->hasPermission(
            PermissionType::CREATE, $this->app->orgId, $this->app->appName, self::MODULE_ID, PermissionState::DRAW)
        ) {
            $response->set('draw_create', null);
            $response->getHeader()->setStatusCode(RequestStatusCode::R_403);
            return;
        }

        if (!empty($val = $this->validateDrawCreate($request))) {
            $response->set('draw_create', new FormValidation($val));

            return;
        }

        $path = MediaController::createMediaPath();
        $extension = 'png';
        $filename = '';
        $rnd = '';

        // todo: implement limit since this could get exploited
        do {
            $filename = sha1($request->getData('image') . $rnd);
            $filename .= '.' . $extension;

            $rnd      = mt_rand();
        } while (file_exists($path . '/' . $filename));

        $fullPath = __DIR__ . '/../../' . $path . '/' . $filename;

        $this->createLocalFile($fullPath, $request->getData('image'));

        $status = [
            'path' => $path,
            'filename' => $filename,
            'name' => $request->getData('title'),
            'size' => File::size($fullPath),
            'extension' => $extension,
            'status' => UploadStatus::OK,
        ];

        $media = MediaController::createDbEntry($status, $request->getHeader()->getAccount());
        $draw = DrawImage::fromMedia($media);

        DrawImageMapper::create($draw);

        $response->set('image', $draw->jsonSerialize());
    }

    private function createLocalFile(string $outputPath, string $raw) : bool
    {
        $imageData = ImageUtils::decodeBase64Image($raw);
        File::put($outputPath, $imageData);

        return true;
    }

}
