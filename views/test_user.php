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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
</head>

<body>
    <p>OK</p>
    <p>Test work</p>
    <?php if ($user_data): ?>
        <p>User first name : <?php echo htmlspecialchars($user_data['first_name'] ?? ''); ?></p>
        <p>User last name : <?php echo htmlspecialchars($user_data['last_name'] ?? ''); ?></p>
        <p>Date of Birth : <?php echo htmlspecialchars($user_data['date_of_birth'] ?? ''); ?></p>
        <p>Email : <?php echo htmlspecialchars($user_data['email'] ?? ''); ?></p>
    <?php else: ?>
        <p>Aucune donnée utilisateur disponible.</p>
    <?php endif; ?>
</body>

</html>