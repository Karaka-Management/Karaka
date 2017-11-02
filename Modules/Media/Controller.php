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
namespace Modules\Media;

use Modules\Media\Models\Media;
use Modules\Media\Models\MediaMapper;
use Modules\Media\Models\CollectionMapper;
use Modules\Media\Models\Collection;

use Modules\Media\Models\UploadFile;
use Modules\Media\Models\UploadStatus;
use phpOMS\Asset\AssetType;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Model\Html\Head;
use phpOMS\Module\ModuleAbstract;
use phpOMS\Module\WebInterface;
use phpOMS\System\MimeType;
use phpOMS\Views\View;
use phpOMS\Message\Http\RequestStatusCode;

/**
 * Media class.
 *
 * @category   Modules
 * @package    Modules\Media
 * @license    OMS License 1.0
 * @link       http://orange-management.com
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
    /* public */ const MODULE_NAME = 'Media';

    /**
     * Module id.
     *
     * @var int
     * @since 1.0.0
     */
    /* public */ const MODULE_ID = 1000400000;

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
    public static function setUpFileUploader(RequestAbstract $request, ResponseAbstract $response, $data = null)
    {
        /** @var Head $head */
        $head = $response->get('Content')->getData('head');
        $head->addAsset(AssetType::JSLATE, $request->getUri()->getBase() . 'Modules/Media/Models/Upload.js');
        $head->addAsset(AssetType::JSLATE, $request->getUri()->getBase() . 'Modules/Media/Controller.js');
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
    public function viewMediaList(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/Media/Theme/Backend/media-list');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1000401001, $request, $response));

        $media = MediaMapper::getNewest(25);
        $view->addData('media', $media);

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
    public function viewMediaSingle(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/Media/Theme/Backend/media-single');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1000401001, $request, $response));

        $media = MediaMapper::get($request->getData('id'));
        if ($media->getExtension() === 'collection') {
            $media = CollectionMapper::get($media->getId());
        }

        $view->addData('media', $media);

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
    public function viewMediaCreate(RequestAbstract $request, ResponseAbstract $response, $data = null) : \Serializable
    {
        $view = new View($this->app, $request, $response);
        $view->setTemplate('/Modules/Media/Theme/Backend/media-create');
        $view->addData('nav', $this->app->moduleManager->get('Navigation')->createNavigationMid(1000401001, $request, $response));

        return $view;
    }

    /**
     * Shows api content.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function apiMediaUpload(RequestAbstract $request, ResponseAbstract $response, $data = null)
    {
        $uploads = $this->uploadFiles($request->getFiles(), $request->getHeader()->getAccount(), $request->getData('path') ?? __DIR__ . '/../../Modules/Media/Files');

        $ids = [];
        foreach ($uploads as $file) {
            $ids[] = $file->getId();
        }

        $response->getHeader()->set('Content-Type', MimeType::M_JSON . '; charset=utf-8', true);
        $response->set($request->__toString(), [['uploads' => $ids, 'type' => 'UI']]);
    }

    /**
     * Shows api content.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function apiMediaCreate(RequestAbstract $request, ResponseAbstract $response, $data = null)
    {
        // todo: change database entry for files if has write permission
    }

    /**
     * @param array  $files    Files
     * @param int    $account  Uploader
     * @param string $basePath Base path
     *
     * @return array
     *
     * @since  1.0.0
     */
    public function uploadFiles(array $files, int $account, string $basePath = 'Modules/Media/Files') : array
    {
        $mediaCreated = [];

        if (!empty($files)) {
            $upload  = new UploadFile();
            $upload->setOutputDir(self::createMediaPath($basePath));

            $status       = $upload->upload($files);
            $mediaCreated = self::createDbEntries($status, $account);
        }

        return $mediaCreated;
    }

    public static function createMediaPath(string $basePath = 'Modules/Media/Files') : string
    {
        $rndPath = str_pad(dechex(rand(0, 65535)), 4, '0', STR_PAD_LEFT);
        return $basePath . '/' . $rndPath[0] . $rndPath[1] . '/' . $rndPath[2] . $rndPath[3];
    }

    /**
     * @param array $status  Files
     * @param int   $account Uploader
     *
     * @return array
     *
     * @since  1.0.0
     */
    public static function createDbEntries(array $status, int $account) : array
    {
        $mediaCreated = [];

        foreach ($status as $uFile) {
            if (!is_null($created = self::createDbEntry($uFile, $account))) {
                $mediaCreated[] = $created;
            }
        }

        return $mediaCreated;
    }

    public static function createDbEntry(array $status, int $account)
    {
        $media = null;

        if ($status['status'] === UploadStatus::OK) {
            $media = new Media();

            $media->setPath(self::normalizeDbPath($status['path']) . '/' . $status['filename']);
            $media->setName($status['name']);
            $media->setSize($status['size']);
            $media->setCreatedBy($account);
            $media->setCreatedAt(new \DateTime('NOW'));
            $media->setExtension($status['extension']);

            MediaMapper::create($media);
        }

        return $media;
    }

    private static function normalizeDbPath(string $path) : string
    {
        return str_replace('\\', '/', 
            str_replace(realpath(__DIR__ . '/../../'), '', 
                rtrim($path, '/')
            )
        );
    }

}
