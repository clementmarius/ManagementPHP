<?php
require_once __DIR__ . '/../controllers/UserController.php';

use App\Management\Controllers\UserController;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller = new UserController;
    $controller->testUser();
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
</head>
<body>
<p>OK</p>
<p>Test work</p>
<p><strong>User Id : </strong><?php echo htmlspecialchars($user_data['id'] ?? '') ?></p>

</body>
</html>