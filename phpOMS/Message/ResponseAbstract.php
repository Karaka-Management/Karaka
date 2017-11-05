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
 * Response abstract class.
 *
 * @category   Framework
 * @package    phpOMS\Message
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
abstract class ResponseAbstract implements MessageInterface, \JsonSerializable
{
    /**
     * Responses.
     *
     * @var string[]
     * @since 1.0.0
     */
    protected $response = [];

    /**
     * Header.
     *
     * @var HeaderAbstract
     * @since 1.0.0
     */
    protected $header = null;

    /**
     * Get response by ID.
     *
     * @param mixed $id Response ID
     *
     * @return mixed
     *
     * @since  1.0.0
     */
    public function &get($id)
    {
        return $this->response[$id];
    }

    /**
     * Add response.
     *
     * @param mixed $key       Response id
     * @param mixed $response  Response to add
     * @param bool  $overwrite Overwrite
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function set($key, $response, bool $overwrite = true) /* : void */
    {
        // This is not working since the key kontains :: from http://
        //$this->response = ArrayUtils::setArray((string) $key, $this->response, $response, ':', $overwrite);
        $this->response[$key] = $response;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return json_encode($this->toArray());
    }

    /**
     * Generate response array from views.
     *
     * @return array
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    abstract public function toArray() : array;

    /**
     * Get header.
     *
     * @return HeaderAbstract
     *
     * @since  1.0.0
     */
    public function getHeader() : HeaderAbstract
    {
        return $this->header;
    }

    /**
     * Get response body.
     *
     * @return string
     *
     * @since  1.0.0
     */
    abstract public function getBody() : string;
}
