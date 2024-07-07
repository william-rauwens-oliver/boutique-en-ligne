<?php
require_once 'db.php';

class ProductDetailsHandler
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getProductDetails($id)
    {
        $query = 'SELECT * FROM products WHERE id = ?';
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getProductReviews($id)
    {
        $query_reviews = 'SELECT * FROM reviews WHERE product_id = ?';
        $stmt_reviews = $this->pdo->prepare($query_reviews);
        $stmt_reviews->execute([$id]);
        return $stmt_reviews->fetchAll();
    }

    public function handleRequest()
    {
        // Récupérer l'ID du produit depuis l'URL
        $id = $_GET['id'] ?? null;

        if (!$id) {
            // Gérer le cas où l'ID n'est pas fourni
            echo 'ID de produit non spécifié.';
            exit;
        }

        // Récupérer les détails du produit
        $product = $this->getProductDetails($id);

        // Vérifier si le produit existe
        if (!$product) {
            echo 'Produit non trouvé.';
            exit;
        }

        // Récupérer les avis sur ce produit
        $reviews = $this->getProductReviews($id);

        return [$product, $reviews];
    }
}
?>
