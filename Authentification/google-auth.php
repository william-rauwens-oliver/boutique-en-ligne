<?php
session_start();

$CLIENT_ID = '994112343166-ed7ptuk74kdqmhvfrgm1p7bv7i476vgb.apps.googleusercontent.com';
$CLIENT_SECRET = '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';
$redirect_uri = 'http://localhost:8888/Boutique-en-ligne/Authentification/google-auth.php'; // Assurez-vous que c'est exactement le même que celui configuré dans la Console Google Cloud

$code = $_POST['code']; // Assurez-vous que vous recevez correctement le code d'autorisation depuis Google OAuth

$url = 'https://oauth2.googleapis.com/token';
$data = array(
    'code' => $code,
    'client_id' => $CLIENT_ID,
    'client_secret' => $CLIENT_SECRET,
    'redirect_uri' => $redirect_uri,
    'grant_type' => 'authorization_code'
);

$options = array(
    'http' => array(
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($data)
    )
);

$context = stream_context_create($options);
$response = file_get_contents($url, false, $context);

if ($response === false) {
    die('Erreur lors de la requête vers Google OAuth');
}

$token_data = json_decode($response, true);

if (isset($token_data['access_token'])) {
    // Succès : vous avez obtenu le jeton d'accès
    $_SESSION['access_token'] = $token_data['access_token'];
    $_SESSION['refresh_token'] = $token_data['refresh_token']; // Optionnel
    header('Location: ../Boutique/Boutique.html'); // Rediriger vers une autre page après l'authentification réussie
    exit();
} else {
    // Erreur lors de l'obtention du jeton d'accès
    die('Erreur lors de l\'échange du code d\'autorisation');
}
?>
