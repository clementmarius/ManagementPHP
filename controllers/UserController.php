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
                /* if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                    throw new Exception("CSRF token invalide."); */
                /* } */

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
                    header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/login.php");
                    /* echo ("ok co"); */
                    exit;
                } else {
                    throw new Exception($result);
                }
            }
        } catch (Exception $e) {
            $_SESSION['register_error'] = $e->getMessage();
            header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/login.php");

            echo ($e->getMessage());
            exit;
        }
    }
}
