<?php

class SessionHandler
{
    public function __construct()
    {
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

$sessionHandler = new SessionHandler();

$response = $sessionHandler->checkLoginStatus();

$sessionHandler->outputJsonResponse($response);

?>
