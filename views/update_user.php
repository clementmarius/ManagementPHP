<?php
require_once __DIR__ . '/../controllers/UserController.php';

use App\Management\Controllers\UserController;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller = new UserController;
    $controller->updateCurrentUser();
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
    error_log("Session démarrée.");
}

$user_data = $_SESSION['user_data'] ?? null;


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="color-scheme" content="light dark" />
    <!-- Pico.css -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@picocss/pico@2.0.6/css/pico.min.css" />
    <title>Update User</title>
</head>

<body>
    <!-- ./ Header -->
    <header class="class container">
        <hgroup>
            <h1>Update User</h1>
            <h2>Welcome</h2>
            <p>This is where you can update your user's informations</p>
        </hgroup>
        <nav>
            <ul>
                <li>
                    <details class="dropdown">
                        <summary role="button" class="primary">Theme</summary>
                        <ul>
                            <li><a href="#" data-theme-switcher="auto">Auto</a></li>
                            <li><a href="#" data-theme-switcher="light">Light</a></li>
                            <li><a href="#" data-theme-switcher="dark">Dark</a></li>
                        </ul>
                    </details>
                </li>
            </ul>
        </nav>
    </header>
    <!-- ./ Header -->
    <!-- ./ Main -->
    <main class="container">

        <!-- ./ Preview -->
        <section id="preview">
            <h2>Preview :</h2>
        </section>
        <!-- ./ Preview -->
        
        <button class="primary" onclick="location.href = '';" id="myButton" class="float-left submit-button">Update Profile</button>
    </main>
    <!-- ./ Main -->





    <!-- Minimal theme switcher -->
    <script src="/public/assets/js/minimal-theme-switcher.js"></script>


    <!-- Modal -->
    <script src="/public/assets/js/modal.js"></script>

</body>

</html>