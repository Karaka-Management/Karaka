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

namespace phpOMS\Router;

use phpOMS\Message\RequestAbstract;

/**
 * Router class.
 *
 * @category   Framework
 * @package    phpOMS\Router
 * @license    OMS License 1.0
 * @link       http://website.orange-management.de
 * @since      1.0.0
 */
class Router
{

    /**
     * Routes.
     *
     * @var array
     * @since 1.0.0
     */
    private $routes = [];

    /**
     * Constructor.
     *
     * @since  1.0.0
     */
    public function __construct()
    {
    }

    /**
     * Add routes from file.
     *
     * @param string $path Route file path
     *
     * @return bool
     *
     * @since  1.0.0
     */
    public function importFromFile(string $path) : bool
    {
        if (file_exists($path)) {
            /** @noinspection PhpIncludeInspection */
            $this->routes += include $path;

            return true;
        }

        return false;
    }

    /**
     * Add route.
     *
     * @param string $route       Route regex
     * @param mixed  $destination Destination e.g. Module:function & verb
     * @param int    $verb        Request verb
     *
     * @return void
     *
     * @since  1.0.0
     */
    public function add(string $route, $destination, int $verb = RouteVerb::GET) /* : void */
    {
        if (!isset($this->routes[$route])) {
            $this->routes[$route] = [];
        }

        $this->routes[$route][] = [
            'dest' => $destination,
            'verb' => $verb,
        ];
    }

    /**
     * Route request.
     *
     * @param string|RequestAbstract $request Request to route
     * @param int             $verb    Route verb
     *
     * @return array[]
     *
     * @throws \InvalidArgumentException
     *
     * @since  1.0.0
     */
    public function route($request, int $verb = RouteVerb::GET) : array
    {
        if ($request instanceof RequestAbstract) {
            $uri  = $request->getUri()->getRoute();
            $verb = $request->getRouteVerb();
        } elseif (is_string($request)) {
            $uri = $request;
        } else {
            throw new \InvalidArgumentException();
        }

        $bound = [];
        foreach ($this->routes as $route => $destination) {
            foreach ($destination as $d) {
                if ($this->match($route, $d['verb'], $uri, $verb)) {
                    $bound[] = ['dest' => $d['dest']];
                }
            }
        }

        return $bound;
    }

    /**
     * Match route and uri.
     *
     * @param string $route      Route
     * @param int    $routeVerb  GET,POST for this route
     * @param string $uri        Uri
     * @param int    $remoteVerb Verb this request is using
     *
     * @return bool
     *
     * @since  1.0.0
     */
    private function match(string $route, int $routeVerb, string $uri, int $remoteVerb = RouteVerb::GET) : bool
    {
        return (bool) preg_match('~^' . $route . '$~', $uri) && ($routeVerb === RouteVerb::ANY || $remoteVerb === RouteVerb::ANY || ($remoteVerb & $routeVerb) === $remoteVerb);
    }
}
