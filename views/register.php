<?php
require_once __DIR__ . '/../controllers/UserController.php';

use App\Management\Controllers\UserController;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new UserController();
    $controller->register();
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
    error_log("Session démarrée.");
}

$error = $_SESSION['register_error'] ?? '';
$success = $_SESSION['success_message'] ?? '';
unset($_SESSION['register_error'], $_SESSION['success_message']);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../public/assets/css/register.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>

<body>

    <?php if ($error) : ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <?php if ($success) : ?>
        <div class="error"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <form action="/PhpPoo/ManagementPhp/register" method="post" enctype="multipart/form-data">
        <h2>Register</h2>

        <label for="name">First Name&nbsp;:</label>
        <input type="text" id="name" name="first_name" placeholder="First Name" value="<?php echo htmlspecialchars($_POST['first_name'] ?? ''); ?>" required>

        <label for="lastName">Last Name&nbsp;:</label>
        <input type="text" id="lastName" name="last_name" placeholder="Last Name" value="<?php echo htmlspecialchars($_POST['last_name'] ?? ''); ?>" required>

        <label for="start">Birthday&nbsp;:</label>
        <input type="date" id="start" name="date_of_birth" value="<?php echo htmlspecialchars($_POST['date_of_birth'] ?? ''); ?>" required>

        <label for="email">Email&nbsp;:</label>
        <input type="email" id="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>

        <label for="password">password&nbsp;:</label>
        <input type="password" id="password" name="password" placeholder="Password" required><br>

        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?? ''; ?>">
        <input type="submit" value="Register">
    </form>

</body>

</html>