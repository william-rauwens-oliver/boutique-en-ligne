<?php
session_start();

$response = array('logged_in' => false);

if (isset($_SESSION['username'])) {
    $response['logged_in'] = true;
    $response['email'] = $_SESSION['user_email']; // Modifier selon la clé de votre session email
}

header('Content-Type: application/json');
echo json_encode($response);
?>
