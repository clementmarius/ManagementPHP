<?php

namespace App\Management\models;

use PDO;
use PDOException;
use DateTime;
use PhpParser\Error;

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

    public function showUser($first_name, $last_name, $email, $date_of_birth)
    {
        try {
            echo 'test';
            $stmt = $this->pdo->prepare("SELECT first_name, last_name, date_of_birth, email FROM users 
            WHERE first_name = :first_name AND last_name = :last_name AND date_of_birth = :date_of_birth AND email = :email");

            // Liaison des paramètres corrects
            $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
            $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
            $stmt->bindParam(':date_of_birth', $date_of_birth, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);

            $stmt->execute();

            // Récupération des résultats
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            return $user ?: false; // Retourne les données ou false si aucun résultat
        } catch (PDOException $e) {
            error_log("Erreur SQL : " . $e->getMessage());
            return "Erreur SQL : " . $e->getMessage();
        }
    }

    public function findUserById(int $id): array
    {
        $request = "SELECT * FROM users WHERE id = :id LIMIT 1";

        $stmt = $this->pdo->prepare($request);

        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        try {
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$data) {
                return ['success' => false, 'message' => "Utilisateur non trouvé."];
            }
            return ['success' => true, 'user' => $data];
        } catch (PDOException $e) {
            error_log("Échec de la recherche de l'utilisateur par ID : " . $e->getMessage());
            return ['success' => false, 'message' => "Erreur interne, veuillez réessayer plus tard."];
        }
    }
}
