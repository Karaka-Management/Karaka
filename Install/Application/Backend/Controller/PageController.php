<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   Web\Backend
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Web\Backend\Controller;

use Modules\CMS\Models\PageMapper;
use phpOMS\Contract\RenderableInterface;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Module\ModuleAbstract;
use phpOMS\Views\View;

/**
 * Home class.
 *
 * @package Web\Backend
 * @license OMS License 1.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
final class PageController extends ModuleAbstract
{
    /**
     * Routing end-point for application behaviour.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return RenderableInterface Returns a renderable object
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewLegalDocuments(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);
        $view->setTemplate('/Web/Backend/Themes/legal');

        /** @var \Modules\CMS\Models\Page $page */
        $page = PageMapper::get()
            ->with('l11n')
            ->where('app', 2)
            ->where('name', $request->uri->getPathElement(1))
            ->where('l11n/language', $response->getLanguage())
            ->execute();

        $view->setData('content', $page);

        return $view;
    }
}
