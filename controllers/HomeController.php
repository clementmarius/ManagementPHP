<?php

namespace App\Management\Controllers;

use App\Management\Router\Router;

class HomeController
{

    public function home()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        require_once __DIR__ . '/../views/home_page.php';
    }
}
