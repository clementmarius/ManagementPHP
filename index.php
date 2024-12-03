<?php

require_once '../ManagementPHP/controllers/UserController.php';
require_once '../ManagementPHP/controllers/Router.php';

use App\Management\Controllers\Router;
use App\Management\Controllers\UserController;

$router = new Router();

//Definir les routes
$router->get('/register', 'register');
$router->post('/register', 'register');
$router->get('/user/profile', 'showUserProfile');
$router->get('/user/(\d+)', 'findUserId');

// Dispatcher la requete 
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestMethod = $_SERVER['REQUEST_METHOD'];

$router->dispatch($uri, $requestMethod);
