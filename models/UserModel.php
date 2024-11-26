<?php

use PDO;
use PDOException;
use DateTime;

require_once __DIR__ . '/../config/database.php';

class UserModel
{

    private $pdo;

    public function __construct()
    {
        try {
            $this->pdo = getDatabaseConnection();
        } catch (PDOException $e) {
            die("Error database connection : " . htmlspecialchars($e->getMessage()));
        }
    }
}
