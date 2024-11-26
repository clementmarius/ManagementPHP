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

    public function verifUser($email, $password)
    {
        try{
            $stmt = $this->pdo->prepare("SELECT id, password FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            if($stmt->rowCount()===1) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if(password_verify($password, $user['password'])) {
                    return $user;
                } else {
                    return "The mail or the password is incorrect.";
                } catch (PDOException $e) {
                    error_log("Error with the user's authentication : " . $e->getMessage());
                    return "Internal mistake, plese try again later.";
                }
            }
        }
    }
}
