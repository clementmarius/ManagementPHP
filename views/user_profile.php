<?php
require_once __DIR__ . '/../controllers/UserController.php';

use App\Management\Controllers\UserController;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller = new UserController;
    $controller->showUserProfile();
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
    error_log("Session démarrée.");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../public/assets/css/profile.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>

<body>
    <p><strong>User Id : </strong><?php echo htmlspecialchars($user_data['id'] ?? '') ?></p>
    <p>User first name : <?php echo htmlspecialchars($user_data['first_name'] ?? ''); ?></p>
    <p>User last name : <?php echo htmlspecialchars($user_data['last_name'] ?? ''); ?></p>
    <p>Date of Birth : <?php echo htmlspecialchars($user_data['date_of_birth'] ?? ''); ?></p>
    <p>Email : <?php echo htmlspecialchars($user_data['email'] ?? ''); ?></p>
</body>

</html>