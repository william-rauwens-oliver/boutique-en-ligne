<?php
class UsersGoogle
{
    private $clientId;
    private $clientSecret;
    private $redirectUri;

    public function __construct()
    {
        session_start();
        $this->clientId = '994112343166-ed7ptuk74kdqmhvfrgm1p7bv7i476vgb.apps.googleusercontent.com';
        $this->clientSecret = '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';
        $this->redirectUri = 'http://localhost:8888/Boutique-en-ligne/Authentification/google-auth.php';
    }

    public function authenticate($code, $redirectUrl)
    {
        $url = 'https://oauth2.googleapis.com/token';
        $data = array(
            'code' => $code,
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri' => $this->redirectUri,
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

        $tokenData = json_decode($response, true);

        if (isset($tokenData['access_token'])) {
            $_SESSION['access_token'] = $tokenData['access_token'];
            $_SESSION['refresh_token'] = $tokenData['refresh_token'];

            // Récupérer les informations utilisateur
            $userInfo = $this->getUserInfo($tokenData['access_token']);
            if ($userInfo) {
                $_SESSION['username'] = $userInfo['email'];  // Enregistrer l'email de l'utilisateur dans la session
                header('Location: ' . $redirectUrl);
                exit();
            } else {
                header('Location: http://localhost:8888/Boutique-en-ligne/page-erreur.php');
                exit();
            }
        } else {
            header('Location: http://localhost:8888/Boutique-en-ligne/page-erreur.php');
            exit();
        }
    }

    private function getUserInfo($accessToken)
    {
        $url = 'https://www.googleapis.com/oauth2/v1/userinfo?access_token=' . $accessToken;
        $response = file_get_contents($url);
        if ($response === false) {
            return null;
        }
        return json_decode($response, true);
    }
}

// Utilisation de la classe
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['code']) && isset($_POST['redirectUrl'])) {
    $usersGoogle = new UsersGoogle();
    $code = $_POST['code'];
    $redirectUrl = 'http://localhost:8888/Boutique-en-ligne/Boutique/Boutique.php'; // Redirection vers la page boutique
    $usersGoogle->authenticate($code, $redirectUrl);
}
?>
