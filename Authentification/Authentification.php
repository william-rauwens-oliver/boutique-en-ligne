<?php
class Users
{
    private $conn;

    public function __construct()
    {
        session_start();
        $this->connectDB();
    }

    private function connectDB()
    {
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "boutique";

        $this->conn = new mysqli($servername, $username, $password, $dbname);

        if ($this->conn->connect_error) {
            die("La connexion a échoué : " . $this->conn->connect_error);
        }
    }

    public function register($user_name, $user_email, $user_password)
    {
        $user_id = rand(0, 100); // Génère un ID utilisateur aléatoire entre 0 et 100
        $hashed_password = password_hash($user_password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO users (users_id, username, email, password) VALUES ('$user_id', '$user_name', '$user_email', '$hashed_password')";

        if ($this->conn->query($sql) === TRUE) {
            return "Inscription réussie";
        } else {
            return "Erreur lors de l'inscription : " . $this->conn->error;
        }
    }

    public function login($user_email, $user_password)
    {
        $sql = "SELECT * FROM users WHERE email='$user_email'";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashed_password = $row['password'];

            if (password_verify($user_password, $hashed_password)) {
                $_SESSION['username'] = $row['username'];
                $_SESSION['user_id'] = $row['users_id'];

                return "Connexion réussie";
            } else {
                return "Mot de passe incorrect. Veuillez réessayer.";
            }
        } else {
            return "Aucun utilisateur trouvé avec cet email. Veuillez vous inscrire.";
        }
    }

    public function __destruct()
    {
        $this->conn->close();
    }
}

// Utilisation de la classe
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    $users = new Users();

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
