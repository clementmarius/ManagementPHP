<?php
require_once __DIR__ . '/../controllers/UserController.php';

use App\Management\Controllers\UserController;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller = new UserController;
    $controller->displayUser();
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
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="color-scheme" content="light dark" />
    <!-- Pico.css -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@picocss/pico@2.0.6/css/pico.min.css" />
    <title>User</title>
</head>

<body>

    <!-- ./ Header -->
    <header class="class container">
        <hgroup>
            <h1>User Page</h1>
            <h2>Welcome</h2>
            <p>This is the User page, more coming soon..</p>
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
        <?php if ($user_data): ?>
            <p><kbd>first name :</kbd> <?php echo htmlspecialchars($user_data['first_name'] ?? ''); ?></p>
            <p><kbd>last name :</kbd> <?php echo htmlspecialchars($user_data['last_name'] ?? ''); ?></p>
            <p><kbd>Date of Birth : </kbd><?php echo htmlspecialchars($user_data['date_of_birth'] ?? ''); ?></p>
            <p><kbd>Email :</kbd> <?php echo htmlspecialchars($user_data['email'] ?? ''); ?></p>
        <?php else: ?>
            <p>Aucune donnée utilisateur disponible.</p>
        <?php endif; ?>
        <button class="primary" onclick="location.href = '';" id="myButton" class="float-left submit-button">Update User</button>
    </main>
    <!-- ./ Main -->





    <!-- Minimal theme switcher -->
    <script src="/public/assets/js/minimal-theme-switcher.js"></script>


    <!-- Modal -->
    <script src="/public/assets/js/modal.js"></script>
</body>

</html>