<?php

namespace App\Management\models;

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
            error_log("Connexion à la base de données établie avec succès.");
        } catch (PDOException $e) {
            error_log("Erreur de connexion à la base de données : " . $e->getMessage());
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

    public function registerUser($first_name, $last_name, $email, $date_of_birth, $password)
    {
        try {
            // Hash du mot de passe
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Insertion dans la base de données
            $stmt = $this->pdo->prepare("
                INSERT INTO users (first_name, last_name, date_of_birth, email, password, is_active)
                VALUES (:first_name, :last_name, :date_of_birth, :email, :password, 1)
            ");

            $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
            $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
            $stmt->bindParam(':date_of_birth', $date_of_birth, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Erreur SQL : " . $e->getMessage());
            return "Erreur SQL : " . $e->getMessage(); // Retourner l'erreur pour débogage
        }
    }

    public function showUser($first_name, $last_name, $email, $date_of_birth) {

        try{
            $stmt = $this->pdo->prepare("SELECT first_name, last_name, date_of_birth, email FROM users 
            WHERE = :first_name, :last_name, :date_of_birth, :email");

            $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
            $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
            $stmt->bindParam(':date_of_birth', $email, PDO::PARAM_STR);
            $stmt->bindParam(':email', $date_of_birth, PDO::PARAM_STR);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("Erreur SQL : " . $e->getMessage());
            return "Erreur SQL : " . $e->getMessage();
        }
    }
}
