<?php

require_once '../ManagementPHP/controllers/UserController.php';


if (isset($_GET['action']) && $_GET['action'] !== '') {
    if ($_GET['action'] === 'post') {
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $identifier = $_GET['id'];

            post($identifier);
        } else {
            echo 'Error : aucun identifiant envoye';

            die;
        }
    } else {
        echo 'Error 404 : La page n\'existe pas';
    }
} else {
    register();
}
