<?php

namespace App\Management\Controllers;

use App\Management\models\UserModel;

use Exception;

require_once __DIR__ . '/../models/UserModel.php';

class UserController
{
    public function register()
    {
        try {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $first_name = htmlspecialchars(trim($_POST['first_name'] ?? ''));
                $last_name = htmlspecialchars(trim($_POST['last_name'] ?? ''));
                $date_of_birth = htmlspecialchars(trim($_POST['date_of_birth'] ?? ''));
                $email = htmlspecialchars(trim($_POST['email'] ?? ''));
                $password = htmlspecialchars(trim($_POST['password'] ?? ''));

                // Log des données pour débogage
                error_log("Données soumises : " . json_encode([
                    'firstName' => $first_name,
                    'lastName' => $last_name,
                    'dateOfBirth' => $date_of_birth,
                    'email' => $email,
                    'password' => $password,
                ]));

                if (empty($first_name) || empty($last_name) || empty($date_of_birth) || empty($email) || empty($password)) {
                    throw new Exception("Tous les champs sont obligatoires.");
                }

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    throw new Exception("Email invalide.");
                }

                $userModel = new UserModel();
                $result = $userModel->registerUser($first_name, $last_name, $email, $date_of_birth, $password);

                if ($result === true) {
                    $_SESSION['success_message'] = "Enregistrement réussi !";
                    header("Location: /login");
                    exit;
                } else {
                    throw new Exception($result);
                }
            } else {
                require_once __DIR__ . '/../views/register.php';
            }
        } catch (Exception $e) {
            $_SESSION['register_error'] = $e->getMessage();
            error_log("Erreur d'enregistrement : " . $e->getMessage()); // Log de l'erreur pour débogage
            header("Location: /register");
            echo ($e->getMessage());
            exit;
        }
    }

    public function displayUser()
    {
        try {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $first_name = htmlspecialchars(trim($_GET['first_name'] ?? ''));
                $last_name = htmlspecialchars(trim($_GET['last_name'] ?? ''));
                $date_of_birth = htmlspecialchars(trim($_GET['date_of_birth'] ?? ''));
                $email = htmlspecialchars(trim($_GET['email'] ?? ''));
                $userModel = new UserModel();

                $result = $userModel->showUser($first_name, $last_name, $email, $date_of_birth);
                if ($result) {
                    $_SESSION['user_data'] = $result;
                    error_log("Utilisateur trouve : " . json_encode($result));
                } else {
                    $_SESSION['display_error'] = "Utilisateur introuvable.";
                    error_log("Utilisateur introuvable avec les donnees fournies.");
                }
            }
        } catch (Exception $e) {
            $_SESSION['display_error'] = $e->getMessage();
            error_log("Erreur dans showUserProfile : " . $e->getMessage());
            header("Location: /user");
            exit;
        }



        require_once __DIR__ . '/../views/user.php';
    }

    public function findUserId($id)
    {
        try {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $userModel = new UserModel();
                $result = $userModel->findUserById($id);
                if ($result) {
                    $_SESSION['user_data'] = $result;
                    error_log("Utilisateur trouvé : " . json_encode($result));
                } else {
                    $_SESSION['display_error'] = "Utilisateur introuvable";
                    error_log("Utilisateur introuvable avec les données fournies.");
                }
            }
        } catch (Exception $e) {
            $_SESSION['display_error'] = $e->getMessage();
            error_log("Erreur dans showUserProfile : " . $e->getMessage());
            header("Location: /PhpPoo/ManagementPHP/user_profile.php");
            exit;
        }
    }
}
