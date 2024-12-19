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

    public function updateCurrentUser()
    {
        try {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                $id = $_SESSION['user_id'] ?? null;


                $id = htmlspecialchars($_POST['id'] ?? '');
                $first_name = htmlspecialchars(trim($_POST['first_name'] ?? ''));
                $last_name = htmlspecialchars(trim($_POST['last_name'] ?? ''));
                $date_of_birth = htmlspecialchars(trim($_POST['date_of_birth'] ?? ''));
                $email = htmlspecialchars(trim($_POST['email'] ?? ''));

                $userModel = new UserModel();
                $result = $userModel->updateUser($id, $first_name, $last_name, $email, $date_of_birth);

                if ($result) {
                    echo "<p> User updated avec son Id : $id</p>";

                    $updatedUser = $userModel->getUserById($id);
                    if ($updatedUser) {
                        $_SESSION['user_data'] = $updatedUser;
                    } else {
                        echo "Impossible de mettre user id : $id";
                    }

                    header("Location: /user");
                    exit;
                } else {
                    echo "<p>La mise à jour a échoué pour l'utilisateur ID : $id</p>";
                }
            }
        } catch (Exception $e) {
            $_SESSION['display_error'] = $e->getMessage();
            echo "<p> Erreur dans Update User : " . $e->getMessage() . "</p>";
            header("Location: /update_user");
            exit;
        }

        require_once __DIR__ . '/../views/update_user.php';
    }

    public function showUserForm()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_data'])) {
            $userId = $_SESSION['user_id'] ?? null;
            if ($userId) {
                $userModel = new UserModel();
                $userData = $userModel->getUserById($userId);
                if ($userData) {
                    $_SESSION['user_data'] = $userData;
                } else {
                    echo "<p style='color:red;'>Erreur : Utilisateur introuvable.</p>";
                    exit;
                }
            }
        }
        require_once __DIR__ . '/../views/update_user.php';
    }

    public function deleteCurrentUser()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!empty($_POST) && isset($_SESSION['user_id'])) {
            $userModel = new UserModel();
            $userId = $_SESSION['user_id'];

            $result = $userModel->deleteUser($userId);

            if ($result !== null) {
                session_unset();
                session_destroy();
                header('Location: /');
                exit;
            } else {
                echo "Erreur lors de la suppresion de l'utilisateur";
            }
        } else {
            echo "Utilisateur non connecte ou requete invalide";
        }
    }
}
