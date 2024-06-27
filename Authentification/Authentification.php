<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "boutique";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La connexion a échoué : " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    if ($_POST['action'] == 'register') {
        $user_name = $_POST['username'];
        $user_email = $_POST['email']; 
        $user_password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $sql = "INSERT INTO users (username, email, password) VALUES ('$user_name', '$user_email', '$user_password')";

        if ($conn->query($sql) === TRUE) {
            echo "Inscription réussie";
        } else {
            echo "Erreur lors de l'inscription : " . $conn->error;
        }
    }

    if ($_POST['action'] == 'login') {
        $user_email = $_POST['email'];
        $user_password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE email='$user_email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashed_password = $row['password'];

            if (password_verify($user_password, $hashed_password)) {
                $_SESSION['username'] = $row['username'];
                $_SESSION['user_id'] = $row['id'];

                header("Location: ../Boutique/Boutique.html");
                exit();
            } else {
                echo "Mot de passe incorrect. Veuillez réessayer.";
            }
        } else {
            echo "Aucun utilisateur trouvé avec cet email. Veuillez vous inscrire.";
        }
    }
}

$conn->close();
?>
