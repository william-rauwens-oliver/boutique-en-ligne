<?php
require_once 'db.php';

class ProductFetcher
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function fetchProducts($category = 'all')
    {
        $query = 'SELECT * FROM products';
        $params = [];

        if ($category !== 'all') {
            $query .= ' WHERE category = ?';
            $params[] = $category;
        }

        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Erreur lors de la récupération des produits: ' . $e->getMessage()]);
            exit;
        }
    }
}

// Utilisation de la classe
header('Content-Type: application/json');
$category = $_GET['category'] ?? 'all';
$productFetcher = new ProductFetcher($pdo); // Utilisation de la connexion PDO depuis db.php
$products = $productFetcher->fetchProducts($category);
echo json_encode($products);
?>
