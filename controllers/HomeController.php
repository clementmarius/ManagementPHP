<?php

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
