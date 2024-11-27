<?php
require_once __DIR__ . '/../controllers/UserController.php';

use App\Management\Controllers\UserController;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new UserController();
    $controller->register();
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
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
    <p>Bonjour</p>
</body>
</html>