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

        header("Location: details.php?id=$product_id");
        exit;
    }

    public function redirectionAccueil()
    {
        header("Location: index.html");
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $user_name = $_POST['user_name'];
    $comment = $_POST['comment'];
    $rating = $_POST['rating'];

    $reviewHandler = new ReviewHandler($pdo);
    $reviewHandler->ajouterAvis($product_id, $user_name, $comment, $rating);
} else {
    $reviewHandler = new ReviewHandler($pdo);
    $reviewHandler->redirectionAccueil();
}
?>
