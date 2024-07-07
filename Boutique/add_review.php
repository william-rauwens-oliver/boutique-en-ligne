<?php
require_once 'db.php';

class ReviewHandler
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
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
    $reviewHandler = new ReviewHandler($pdo);
    $reviewHandler->ajouterAvis($product_id, $user_name, $comment, $rating);
} else {
    // Redirection vers la page d'accueil si le formulaire n'a pas été soumis directement
    $reviewHandler = new ReviewHandler($pdo);
    $reviewHandler->redirectionAccueil();
}
?>
