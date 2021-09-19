<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   Web\Backend
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Web\Backend\Controller;

/**
 * Home class.
 *
 * @package Web\Backend
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
final class PageController extends Controller
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
    public function viewLegalDocuments(RequestAbstract $request, ResponseAbstract $response, $data = null) : RenderableInterface
    {
    	$view = new View($this->app->l11nManager, $request, $response);
    	$view->setTemplate('/Web/Backend/Theme/legal');

    	$page = PageMapper::with('app', 2)::getBy($request->getPath(1), 'name');

    	return $view;
    }
}