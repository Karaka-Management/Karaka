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

namespace phpOMS\Message\Http;

use phpOMS\Contract\RenderableInterface;
use phpOMS\Localization\Localization;
use phpOMS\Message\ResponseAbstract;
use phpOMS\System\MimeType;
use phpOMS\Views\View;

/**
 * Response class.
 *
 * @category   Framework
 * @package    phpOMS\Response
 * @license    OMS License 1.0
 * @link       http://orange-management.com
 * @since      1.0.0
 */
class Response extends ResponseAbstract implements RenderableInterface
{
    /**
     * Response status.
     *
     * @var int
     * @since 1.0.0
     */
    protected $status = RequestStatusCode::R_200;

    /**
     * Constructor.
     *
     * @param Localization $l11n Localization
     *
     * @since  1.0.0
     */
    public function __construct(Localization $l11n = null)
    {
        $this->header = new Header();
        $this->header->setL11n($l11n ?? new Localization());
    }

    /**
     * Set response.
     *
     * @param array $response Response to set
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function setResponse(array $response) /* : void */
    {
        $this->response = $response;
    }

    /**
     * Remove response by ID.
     *
     * @param mixed $id Response ID
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function remove($id) : bool
    {
        if (isset($this->response[$id])) {
            unset($this->response[$id]);

            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getBody() : string
    {
        return $this->render();
    }

    /**
     * Generate response based on header.
     *
     * @return string
     *
     * @since  1.0.0
     */
    public function render() : string
    {
        $types = $this->header->get('Content-Type');

        foreach ($types as $type) {
            if (stripos($type, MimeType::M_JSON) !== false) {
                return $this->jsonSerialize();
            }
        }

        return $this->getRaw();
    }

    /**
     * Generate raw response.
     *
     * @return string
     *
     * @throws \Exception
     *
     * @since  1.0.0
     */
    private function getRaw() : string
    {
        $render = '';

        foreach ($this->response as $key => $response) {
            if ($response instanceOf \Serializable) {
                $render .= $response->serialize();
            } elseif (is_string($response) || is_numeric($response)) {
                $render .= $response;
            } elseif (is_array($response)) {
                $render .= json_encode($response);
                // TODO: remove this. This should never happen since then someone forgot to set the correct header. it should be json header!
            } else {
                throw new \Exception('Wrong response type');
            }
        }

        $types = $this->header->get('Content-Type');
        
        if (stripos($types[0], MimeType::M_HTML) !== false) {
            return trim(preg_replace('/(\s{2,}|\n|\t)(?![^<>]*<\/pre>)/', ' ', $render));
        }

        return $render;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray() : array
    {
        $result = [];

        try {
            foreach ($this->response as $key => $response) {
                if ($response instanceof View) {
                    $result += $response->toArray();
                } elseif (is_array($response)) {
                    $result += $response;
                } elseif (is_scalar($response)) {
                    $result[] = $response;
                } elseif ($response instanceof \JsonSerializable) {
                    $result[] = $response->jsonSerialize();
                } else {
                    throw new \Exception('Wrong response type');
                }
            }
        } catch (\Exception $e) {
            // todo: handle exception
            // need to to try catch for logging. otherwise the json_encode in the logger will have a problem with this
            $result = [];
        } finally {
            return $result;
        }
    }
}
