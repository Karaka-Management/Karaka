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
namespace Modules\Media\Models;

use phpOMS\System\File\Local\Directory;


/**
 * Upload.
 *
 * @category   Modules
 * @package    Modules\Media
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class UploadFile
{
    /* public */ const PATH_GENERATION_LIMIT = 1000;

    /**
     * Image interlaced.
     *
     * @var int
     * @since 1.0.0
     */
    private $interlaced = true;

    /**
     * Upload max size.
     *
     * @var int
     * @since 1.0.0
     */
    private $maxSize = 50000000;

    /**
     * Allowed mime types.
     *
     * @var array
     * @since 1.0.0
     */
    private $allowedTypes = [];

    /**
     * Output directory.
     *
     * @var string
     * @since 1.0.0
     */
    private $outputDir = __DIR__ . '/../../Modules/Media/Files';

    /**
     * Output file name.
     *
     * @var string
     * @since 1.0.0
     */
    private $fileName = '';

    /**
     * Output file name.
     *
     * @var bool
     * @since 1.0.0
     */
    private $preserveFileName = true;

    /**
     * Upload file to server.
     *
     * @param array $files File data ($_FILE)
     *
     * @return array
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    public function upload(array $files) : array
    {
        $result = [];

        if (count($files) == count($files, COUNT_RECURSIVE)) {
            $files = [$files];
        }

        $this->findOutputDir($files);
        $path = $this->outputDir;

        foreach ($files as $key => $f) {
            $result[$key]           = [];
            $result[$key]['status'] = UploadStatus::OK;

            if (!isset($f['error'])) {
                // TODO: handle wrong parameters
                $result[$key]['status'] = UploadStatus::WRONG_PARAMETERS;

                return $result;
            } elseif ($f['error'] !== UPLOAD_ERR_OK) {
                $result[$key]['status'] = $this->getUploadError($f['error']);

                return $result;
            }

            $result[$key]['size'] = $f['size'];

            if ($f['size'] > $this->maxSize) {
                // too large2
                $result[$key]['status'] = UploadStatus::CONFIG_SIZE;

                return $result;
            }

            // TODO: do I need pecl fileinfo?
            if (!empty($this->allowedTypes) && ($ext = array_search($f['type'], $this->allowedTypes, true)) === false) {
                // wrong file format
                $result[$key]['status'] = UploadStatus::WRONG_EXTENSION;

                return $result;
            }

            if ($this->preserveFileName) {
                $this->fileName = $f['name'];
            }

            $split                     = explode('.', $f['name']);
            $result[$key]['name'] = $split[0];
            $extension                 = count($split) > 1 ? $split[count($split) - 1] : '';
            $result[$key]['extension'] = $extension;

            // ! and empty same?!
            $result[$key]['filename'] = $this->fileName;
            if (!$this->fileName || empty($this->fileName) || file_exists($path . '/' . $this->fileName)) {
                $rnd = '';

                $limit = 0;
                do {
                    $sha = sha1_file($f['tmp_name'] . $rnd);

                    if ($sha === false) {
                        $result[$key]['status'] = UploadStatus::FAILED_HASHING;

                        return $result;
                    }

                    $sha .= '.' . $extension;

                    $this->fileName = $sha;
                    $rnd            = mt_rand();
                    $limit++;
                } while (file_exists($path . '/' . $this->fileName) && $limit < self::PATH_GENERATION_LIMIT);

                if ($limit >= self::PATH_GENERATION_LIMIT) {
                    throw new \Exception('No file path could be found. Potential attack!');
                }
            }

            if (!is_dir($path)) {
                Directory::create($path, 0655, true);
            }

            if (!is_uploaded_file($f['tmp_name'])) {
                $result[$key]['status'] = UploadStatus::NOT_UPLOADED;

                return $result;
            }

            if (!move_uploaded_file($f['tmp_name'], $dest = $path . '/' . $this->fileName)) {
                $result[$key]['status'] = UploadStatus::NOT_MOVABLE;

                return $result;
            }

            if ($this->interlaced && in_array($extension, ['png', 'jpg', 'jpeg', 'gif'])) {
                $this->interlace($extension, $dest);
            }

            $result[$key]['path'] = realpath($this->outputDir);
        }

        return $result;
    }

    private function interlace(string $extension, string $path) /* : void */
    {
        
                if ($extension === 'png') {
                    $img = imagecreatefrompng($path);
                } elseif ($extension === 'jpg' || $extension === 'jpeg') {
                    $img = imagecreatefromjpeg($path);
                } else {
                    $img = imagecreatefromgif($path);
                }

                imageinterlace($img, (int) $this->interlaced);

                if ($extension === 'png') {
                    imagepng($img, $path);
                } elseif ($extension === 'jpg' || $extension === 'jpeg') {
                    imagejpeg($img, $path);
                } else {
                    imagegif($img, $path);
                }

                imagedestroy($img);
    }

    /**
     * Find unique output path for batch of files
     *
     * @param array $files Array of files
     *
     * @return void
     *
     * @since  1.0.0
     */
    private function findOutputDir(array $files)
    {
        if (count($files) > 1) {
            do {
                $rndPath = str_pad(dechex(rand(0, 65535)), 4, '0', STR_PAD_LEFT);
            } while (file_exists($this->outputDir . '/' . $rndPath));

            $this->outputDir = $this->outputDir . '/' . $rndPath;
        }
    }

    /**
     * Get upload error
     *
     * @param mixed $error Error type
     *
     * @return int
     *
     * @since  1.0.0
     */
    private function getUploadError($error) : int
    {
        switch ($error) {
            case UPLOAD_ERR_NO_FILE:
                // TODO: no file sent
                return UploadStatus::NOTHING_UPLOADED;
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                return UploadStatus::UPLOAD_SIZE;
            default:
                return UploadStatus::UNKNOWN_ERROR;
        }
    }

    /**
     * @return int
     *
     * @since  1.0.0
     */
    public function getMaxSize() : int
    {
        return $this->maxSize;
    }

    public function setInterlaced(bool $interlaced) /* : void */
    {
        $this->interlaced = $interlaced;
    }

    /**
     * @param int $maxSize
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setMaxSize(int $maxSize)
    {
        $this->maxSize = $maxSize;
    }

    /**
     * @return array
     *
     * @since  1.0.0
     */
    public function getAllowedTypes() : array
    {
        return $this->allowedTypes;
    }

    /**
     * @param array $allowedTypes
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setAllowedTypes(array $allowedTypes)
    {
        $this->allowedTypes = $allowedTypes;
    }

    /**
     * @param array $allowedTypes
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function addAllowedTypes($allowedTypes)
    {
        $this->allowedTypes[] = $allowedTypes;
    }

    /**
     * @return string
     *
     * @since  1.0.0
     */
    public function getOutputDir() : string
    {
        return $this->outputDir;
    }

    /**
     * @param string $outputDir
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setOutputDir(string $outputDir)
    {
        $this->outputDir = $outputDir;
    }

    /**
     * @return string
     *
     * @since  1.0.0
     */
    public function getFileName() : string
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setFileName(string $fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * @param bool $preserveFileName
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setPreserveFileName(bool $preserveFileName)
    {
        $this->preserveFileName = $preserveFileName;
    }
}
