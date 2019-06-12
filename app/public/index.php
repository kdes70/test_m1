<?php

declare(strict_types=1);

use Illuminate\Http\Response;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;


error_reporting(E_ALL);

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

if (file_exists('.env')) {
    (new Dotenv())->load('.env');
}

try {

    // Init basic route
    $foo_route = new Route(
        '/',
        ['_controller' => 'App\Http\Controllers\IndexController', 'method' => 'list']
    );

    $routes = new RouteCollection();
    $routes->add('home', $foo_route);

    $request = Request::createFromGlobals();

    // Init RequestContext object
    $context = new RequestContext();
    $context->fromRequest($request);

    // Init UrlMatcher object
    $matcher = new UrlMatcher($routes, $context);

    // Find the current route
    $parameters = $matcher->match($context->getPathInfo());

//    // How to generate a SEO URL
    $generator = new UrlGenerator($routes, $context);


    try {

        $request->attributes->add($parameters);

        $name = ucfirst($request->attributes->get('_controller'));

        $controller = new $name;

        if ((new \ReflectionClass($controller))->hasMethod($parameters['method']) &&
            (new \ReflectionMethod($controller, $parameters['method']))->isPublic()) {

            $response = call_user_func([$controller, $parameters['method']], $request);

        } else {
            call_user_func(array($controller, 'pageNotFound'));
        }

    } catch (ResourceNotFoundException $e) {

        $response = new Response('Not Found', 404);

    } catch (Exception $e) {

        $response = new Response('An error occurred', 500);
    }

//     return $response->send();
//    exit;
} catch (ResourceNotFoundException $e) {
    echo $e->getMessage();
}
