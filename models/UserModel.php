<?php
namespace App\Doranconet\models;

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
            die("Erreur de connexion à la base de données : " . htmlspecialchars($e->getMessage()));
        }
    }

    public function verifUser($email, $password)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT id, email, password FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() === 1) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if (password_verify($password, $user['password'])) {
                    return $user;
                } else {
                    return "The password or the mail is incorrect.";
                }
            } else {
                return "The password or the mail is incorrect.";
            }
        } catch (PDOException $e) {
            error_log("Error during the user's authentification : " . $e->getMessage());
            return "Internal error, please try again later.";
        }
    }



}
?>