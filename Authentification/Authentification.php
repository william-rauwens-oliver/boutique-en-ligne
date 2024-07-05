<?php
require_once 'db.php';

class Users
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        session_start();
        $this->pdo = $pdo;
    }

    public function register($user_name, $user_email, $user_password)
    {
        $user_id = rand(0, 100);
        $hashed_password = password_hash($user_password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO users (users_id, username, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);

        try {
            $stmt->execute([$user_id, $user_name, $user_email, $hashed_password]);
            return "Inscription réussie";
        } catch (PDOException $e) {
            return "Erreur lors de l'inscription : " . $e->getMessage();
        }
    }

    public function login($user_email, $user_password)
    {
        $sql = "SELECT * FROM users WHERE email=?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_email]);
        $user = $stmt->fetch();

        if ($user) {
            $hashed_password = $user['password'];

            if (password_verify($user_password, $hashed_password)) {
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_id'] = $user['users_id'];

                return "Connexion réussie";
            } else {
                return "Mot de passe incorrect. Veuillez réessayer.";
            }
        } else {
            return "Aucun utilisateur trouvé avec cet email. Veuillez vous inscrire.";
        }
    }
}

// Utilisation de la classe
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    $users = new Users($pdo);

    if ($_POST['action'] == 'register') {
        $user_name = $_POST['username'];
        $user_email = $_POST['email'];
        $user_password = $_POST['password'];
        echo $users->register($user_name, $user_email, $user_password);
    }

    if ($_POST['action'] == 'login') {
        $user_email = $_POST['email'];
        $user_password = $_POST['password'];
        echo $users->login($user_email, $user_password);
    }
}
?>
