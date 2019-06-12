<?php


namespace App\Core;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

class Routing
{

    /**
     * @var static
     */
    private $request;

    public function __construct()
    {
        $this->request = Request::createFromGlobals();

    }

    public function resolve()
    {

        // Get routes list
        $routes_list = routes();

        $curent = $this->addRoute($routes_list);

        // Init RequestContext object
        $context = new RequestContext();
        $context->fromRequest($this->request);

        // Init UrlMatcher object
        $matcher = new UrlMatcher($curent, $context);

        // Find the current route
        $parameters = $matcher->match($context->getPathInfo());

        // How to generate a URL
        // $generator = new UrlGenerator($routes, $context);

        $this->request->attributes->add($parameters);

        return $this->request;
    }


    private function addRoute($routes_list)
    {
        $routes = new RouteCollection();
        foreach ($routes_list as $key => $route) {

            $routes->add($key, $route);
        }

        return $routes ?? null;
    }
}