<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Web\Backend\Views
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Web\Backend\Views;

use phpOMS\Localization\L11nManager;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Views\View;

/**
 * Component view.
 *
 * @package Web\Backend\Views
 * @license OMS License 2.2
 * @link    https://jingga.app
 * @since   1.0.0
 * @codeCoverageIgnore
 */
class L11nView extends View
{
    public string $ref = '';

    /**
     * L11ns
     *
     * @var array
     * @since 1.0.0
     */
    public array $l11ns = [];

    /**
     * L11n types
     *
     * @var array
     * @since 1.0.0
     */
    public array $l11nTypes = [];

    /**
     * API Uri for attribute actions
     *
     * @var string
     * @since 1.0.0
     */
    public string $apiUri = '';

    /**
     * {@inheritdoc}
     */
    public function __construct(?L11nManager $l11n = null, ?RequestAbstract $request = null, ?ResponseAbstract $response = null)
    {
        parent::__construct($l11n, $request, $response);
        $this->setTemplate('/Web/Backend/Themes/l11n-list');
    }

    /**
     * {@inheritdoc}
     */
    public function render(mixed ...$data) : string
    {
        /** @var array{0:\phpOMS\Localization\BaseStringL11n[]} $data */
        $this->l11ns     = $data[0];
        $this->l11nTypes = $data[1];
        $this->apiUri    = $data[2];
        $this->ref    = $data[4] ?? '';

        return parent::render();
    }
}
