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
            <form action="/user" method="POST">
                <h2>User's Informations : </h2>
                <div>
                    <label for="name">First Name&nbsp;:</label>
                    <input type="text" id="name" name="first_name" placeholder="First Name" aria-label="First Name" value="<?php echo htmlspecialchars($_POST['first_name'] ?? ''); ?>" required>

                    <label for="lastName">Last Name&nbsp;:</label>
                    <input type="text" id="lastName" name="last_name" placeholder="Last Name" aria-label="Last Name" value="<?php echo htmlspecialchars($_POST['last_name'] ?? ''); ?>" required>

                    <label for="start">Birthday&nbsp;:</label>
                    <input type="date" id="start" name="date_of_birth" aria-label="Date of Birth" value="<?php echo htmlspecialchars($_POST['date_of_birth'] ?? ''); ?>" required>

                    <label for="email">Email&nbsp;:</label>
                    <input type="email" id="email" name="email" placeholder="Email" aria-label="Email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>

                    <input type="hidden" name="csrf_token" value="">
                    <input type="submit" value="Update">
                </div>
            </form>
        </section>
        <!-- ./ Preview -->
    </main>
    <!-- ./ Main -->





    <!-- Minimal theme switcher -->
    <script src="/public/assets/js/minimal-theme-switcher.js"></script>


    <!-- Modal -->
    <script src="/public/assets/js/modal.js"></script>

</body>

</html>