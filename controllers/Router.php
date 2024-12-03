<?php

namespace App\Management\Controllers;

class Router
{
    private $routes = [];

    public function get($path, $controllerMethod)
    {
        $this->routes['GET'][$path] = $controllerMethod;
    }

    public function post($path, $controllerMethod)
    {
        $this->routes['POST'][$path] = $controllerMethod;
    }

    public function dispatch($uri, $requestMethod)
    {
        foreach ($this->routes[$requestMethod] as $path => $controllerMethod) {
            if (preg_match("#^$path$#", $uri, $matches)) {
                // Extract the controller and method name
                list($controller, $method) = explode('@', $controllerMethod);

                // Instantiate the controller
                $controllerInstance = new $controller();

                // Remove the matched path from the URI
                array_shift($matches);

                // Call the controller method with the remaining URI parts as arguments
                call_user_func_array([$controllerInstance, $method], $matches);
                return;
            }
        }
        echo 'Error 404 : La page n\'existe pas';
    }
}
