<?php

namespace App\Management\Controllers;

class PostController
{

    public function viewPost()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        require_once __DIR__ . '/../views/view_posts.php';
    }
}
