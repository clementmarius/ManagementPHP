<?php

namespace App\Management\Controllers;

class Router
{

    private $routes = [];

    public function get($path, $controllerMethod)
    {
        $this->routes['GET'][$path] = $controllerMethod;
    }

    
}
