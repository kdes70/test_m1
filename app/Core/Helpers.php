<?php

use App\Core\Support\Dumper;
use Symfony\Component\Routing\Route;

if (!function_exists('dd')) {
    /**
     * Dump the passed variables and end the script.
     *
     * @param mixed $args
     * @return void
     */
    function dd(...$args)
    {
        foreach ($args as $x) {
            (new Dumper)->dump($x);
        }

        die(1);
    }
}

if (!function_exists('routes')) {
    /**
     * Get routes config
     *
     * @return array
     */
    function routes()
    {
        $route = include ROOT_PATH . DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR . 'Http' . DIRECTORY_SEPARATOR . 'route.php';

        $res = [];

        foreach ($route as $name => $params) {
            $res[$name] = new Route(
                $params['path'], [
                    '_controller' => $params['controller'],
                    'method' => $params['method']]
            );
        }

        return $res;
    }
}