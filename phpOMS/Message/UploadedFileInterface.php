<?php
/**
 * Orange Management
 *
 * PHP Version 7.1
 *
 * @category   Framework
 * @package    phpOMS\Message
 * @copyright  Dennis Eichhorn
 * @license    OMS License 1.0
 * @version    1.0.0
 * @link       http://website.orange-management.de
 */
declare(strict_types = 1);

namespace phpOMS\Message;

/**
 * Upload interface.
 *
 * @category   Framework
 * @package    phpOMS\Message
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
interface UploadedFileInterface
{

    /**
     * Retrieve a stream representing the uploaded file.
     *
     * @since  1.0.0
     */
    public function getStream();

    /**
     * Move the uploaded file to a new location.
     *
     * @param string $targetPath Path to new location
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function moveTo(string $targetPath);

    /**
     * Retrieve the file size.
     *
     * @since  1.0.0
     */
    public function getSize();

    /**
     * Retrieve the error associated with the uploaded file.
     *
     * @since  1.0.0
     */
    public function getError();

    /**
     * Retrieve the filename sent by the client.
     *
     * @since  1.0.0
     */
    public function getClientFilename();

    /**
     * Retrieve the media type sent by the client.
     *
     * @since  1.0.0
     */
    public function getClientMediaType();
}
