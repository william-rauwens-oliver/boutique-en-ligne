<?php

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
        $id = $_GET['id'] ?? null;

        if (!$id) {
            echo 'ID de produit non spécifié.';
            exit;
        }

        $product = $this->getProductDetails($id);

        if (!$product) {
            echo 'Produit non trouvé.';
            exit;
        }

        $reviews = $this->getProductReviews($id);

        return [$product, $reviews];
    }
}

?>
