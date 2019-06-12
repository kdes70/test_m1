<?php


namespace App\Core;

use Throwable;

class App
{
    public static $router;

    public static $db;

    public static $kernel;

    public static function init()
    {
        static::bootstrap();
        //set_exception_handler(['App', 'handleException']);
    }

    public static function bootstrap()
    {
        static::$router = new Routing();
        static::$kernel = new Kernel();
        static::$db =  new Database();
    }

//    public function handleException(Throwable $e)
//    {
//
//        if ($e instanceof \App\Exceptions\InvalidRouteException) {
//            echo static::$kernel->launchAction('Error', 'error404', [$e]);
//        } else {
//            echo static::$kernel->launchAction('Error', 'error500', [$e]);
//        }
//
//    }
}