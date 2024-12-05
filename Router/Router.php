<?php

namespace App\Management\Router\Router;

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
        // Affichage des routes disponibles pour le debug
        error_log("Routes disponibles pour la méthode $requestMethod : " . print_r($this->routes[$requestMethod], true));
        error_log("URI demandée : $uri");

        if (!isset($this->routes[$requestMethod])) {
            echo 'Erreur 404 : Méthode non prise en charge';
            return;
        }

        foreach ($this->routes[$requestMethod] as $path => $controllerMethod) {
            if (preg_match("#^$path$#", $uri, $matches)) {
                if (is_callable($controllerMethod)) {
                    call_user_func($controllerMethod);
                    return;
                }

                list($controller, $method) = explode('@', $controllerMethod);
                $controllerInstance = new $controller();

                array_shift($matches);
                call_user_func_array([$controllerInstance, $method], $matches);
                return;
            }
        }
        echo 'Erreur 404 : La page n\'existe pas';
    }
}
