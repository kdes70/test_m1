<?php


namespace App\Core;


use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class Kernel
{

    public $path_controller = 'Http' . DIRECTORY_SEPARATOR . 'Controllers';
    public $namespace_controller = 'App\\Http\\Controllers\\';

    public $default_controller_name = 'IndexController';

    public $default_action_name = "index";

    /**
     * @var Request
     */
    private $request;

    /**
     *
     */
    public function handle()
    {
        $this->request = App::$router->resolve();

        echo $this->launchAction(
            $this->request->attributes->get('_controller'),
            $this->request->attributes->get('method')
        );
    }


    public function launchAction(string $controller_name, string $method_name)
    {

        try {

            $controller_name = empty($controller_name) ? $this->default_controller_name : ucfirst($controller_name);

            if (!file_exists(ROOT_PATH . DIRECTORY_SEPARATOR . $this->path_controller . DIRECTORY_SEPARATOR . $controller_name . '.php')) {
                throw new \App\Exceptions\InvalidRouteException();
            }

            if(!class_exists($this->namespace_controller .ucfirst($controller_name))){
                throw new \App\Exceptions\InvalidRouteException();
            }

            $controller_name = $this->namespace_controller . $controller_name;

            $controller = new $controller_name;

            if ((new \ReflectionClass($controller))->hasMethod($method_name) &&
                (new \ReflectionMethod($controller, $method_name))->isPublic()) {

                return call_user_func([$controller, $method_name], $this->request);

            } else {

                $response = new Response('Not Found method '. $method_name, 404);
            }

        } catch (ResourceNotFoundException $e) {

            $response = new Response('Not Found', 404);

        } catch (Exception $e) {

            $response = new Response('An error occurred', 500);
        }

        return $response->send();

    }

}