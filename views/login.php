<?php

require_once __DIR__ . '/../controllers/AuthController.php';

use App\Management\Controllers\AuthController;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new AuthController();
    $controller->login();
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
    error_log("Session démarrée.");
}

$error = $_SESSION['login_error'] ?? '';
$success = $_SESSION['success_message'] ?? '';
unset($_SESSION['login_error'], $_SESSION['success_message']);
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
    <title>Login Page</title>
</head>

<body>

    <?php if ($error) : ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if ($success) : ?>
        <div class="error"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <!-- Header -->
    <header class="container">
        <hgroup>
            <h1>Register</h1>
            <p>Register bellow.</p>
        </hgroup>
        <nav>
            <ul>
                <li>
                    <details class="dropdown">
                        <summary role="button" class="secondary">Theme</summary>
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

    <!-- Main -->
    <main class="container">
        <!-- Form elements-->
        <section id="form">
            <form action="/login" method="POST">
                <h2>Login Page</h2>
                <div>
                    <label for="email">Email&nbsp;</label>
                    <input type="email" id="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>

                    <label for="password">password&nbsp;:</label>
                    <input type="password" id="password" name="password" placeholder="Password" required><br>

                    <input type="hidden" name="csrf_token" value="">
                    <input type="submit" value="login">
                </div>
            </form>
        </section>
        <!-- ./ Form elements-->

    </main>
    <!-- ./ Main -->

    <!-- Footer -->
    <footer class="container">
        <small>Built with <a href="https://picocss.com">Pico</a> •
            <a href="https://github.com/clementmarius">Source code</a></small>
    </footer>
    <!-- ./ Footer -->

    <!-- Minimal theme switcher -->
    <script src="/public/assets/js/minimal-theme-switcher.js"></script>


    <!-- Modal -->
    <script src="/public/assets/js/modal.js"></script>
</body>

</html>