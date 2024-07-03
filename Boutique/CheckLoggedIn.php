<?php

class SessionHandler
{
    public function __construct()
    {
        // Démarrer la session si ce n'est pas déjà fait
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function checkLoginStatus()
    {
        $response = array('logged_in' => false);

        if (isset($_SESSION['username'])) {
            $response['logged_in'] = true;
            $response['email'] = $_SESSION['user_email'];
        }

        return $response;
    }

    public function outputJsonResponse($response)
    {
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}

// Créer une instance de SessionHandler
$sessionHandler = new SessionHandler();

// Vérifier le statut de connexion et obtenir la réponse
$response = $sessionHandler->checkLoginStatus();

// Sortir la réponse en JSON
$sessionHandler->outputJsonResponse($response);

?>
