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
            if (preg_match("#^path$#", $uri, $matches)) {
                $controller = new UserController();
                $method = $controllerMethod;
                array_shift($matches);
                call_user_func_array([$controller, $method], $matches);
                return;
            }
        }
        echo 'Error 404 : La page n\'existe pas';
    }
}
