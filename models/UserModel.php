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
            $stmt = $this->pdo->prepare("SELECT id, email, first_name, last_name, date_of_birth, password FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() === 1) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if (password_verify($password, $user['password'])) {
                    return [
                        'id' => $user['id'],
                        'first_name' => $user['first_name'],
                        'last_name' => $user['last_name'],
                        'email' => $user['email'],
                        'date_of_birth' => $user['date_of_birth']
                    ];
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

    public function updateUser($id, $first_name, $last_name, $email, $date_of_birth)
    {
        try {
            // Correction de la requête SQL avec les colonnes et les placeholders correspondants
            $stmt = $this->pdo->prepare(
                "UPDATE users SET 
                    first_name = :first_name, 
                    last_name = :last_name, 
                    email = :email, 
                    date_of_birth = :date_of_birth 
                 WHERE id = :id"
            );

            // Liaison des paramètres
            $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
            $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':date_of_birth', $date_of_birth, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            // Exécution de la requête
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            error_log("Echec de la mise à jour des informations de l'utilisateur par ID : " . $e->getMessage());
            return "Erreur SQL : " . $e->getMessage();
        }
    }

    public function getUserById($id)
    {

        try {
            $query = "SELECT id, first_name, last_name, email, date_of_birth FROM users WHERE id = :id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la recuperation de l'utilisateur par ID :" . $e->getMessage());
            return null;
        }
    }

    public function deleteUser($id)
    {
        try {
            $query = "DELETE FROM users WHERE id =:id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Erreur lors de la suppresion de l'utilisateur par ID :" . $e->getMessage());
            return false;
        }
    }
}
