<?php

class ReviewHandler
{
    private $dbHost = 'localhost';
    private $dbName = 'boutique';
    private $dbUser = 'root';
    private $dbPass = 'root';
    private $charset = 'utf8mb4';
    private $pdo;

    public function __construct()
    {
        $dsn = "mysql:host={$this->dbHost};dbname={$this->dbName};charset={$this->charset}";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $this->dbUser, $this->dbPass, $options);
        } catch (PDOException $e) {
            echo 'Erreur de connexion à la base de données: ' . $e->getMessage();
            exit;
        }
    }

    public function ajouterAvis($product_id, $user_name, $comment, $rating)
    {
        $query = 'INSERT INTO reviews (product_id, user_name, comment, rating) VALUES (?, ?, ?, ?)';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$product_id, $user_name, $comment, $rating]);

        // Redirection vers la page des détails du produit après l'ajout de l'avis
        header("Location: details.php?id=$product_id");
        exit;
    }

    public function redirectionAccueil()
    {
        header("Location: index.html");
        exit;
    }
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $product_id = $_POST['product_id'];
    $user_name = $_POST['user_name'];
    $comment = $_POST['comment'];
    $rating = $_POST['rating'];

    // Créer une instance de ReviewHandler et ajouter l'avis
    $reviewHandler = new ReviewHandler();
    $reviewHandler->ajouterAvis($product_id, $user_name, $comment, $rating);
} else {
    // Redirection vers la page d'accueil si le formulaire n'a pas été soumis directement
    $reviewHandler = new ReviewHandler();
    $reviewHandler->redirectionAccueil();
}
?>
