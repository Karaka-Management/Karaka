<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\Media
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Web\Backend\Views;

use Modules\Media\Models\Collection;
use phpOMS\Localization\L11nManager;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Views\View;

/**
 * Component view.
 *
 * @package Modules\Media
 * @license OMS License 2.2
 * @link    https://jingga.app
 * @since   1.0.0
 * @codeCoverageIgnore
 */
class BaseView extends View
{
    /**
     * Exporter
     *
     * @var array
     * @since 1.0.0
     */
    protected array $exporter;

    /**
     * {@inheritdoc}
     */
    public function __construct(?L11nManager $l11n = null, ?RequestAbstract $request = null, ?ResponseAbstract $response = null)
    {
        parent::__construct($l11n, $request, $response);
        $this->setTemplate('/Web/Backend/Themes/Backend/popup-additional-function');
    }

    /**
     * Add exporter to the table
     *
     * @param string     $type  Exporter type
     * @param Collection $media Media to the exporter
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function addExporter(string $type, Collection $media) : void
    {
        $this->exporter[$type][] = $media;
    }
}
