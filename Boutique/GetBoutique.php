<?php

class ProductFetcher
{
    private $pdo;

    public function __construct()
    {
        $host = 'localhost';
        $db = 'boutique';
        $user = 'root';
        $pass = 'root';
        $charset = 'utf8mb4';
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            echo json_encode(['error' => 'Erreur de connexion à la base de données: ' . $e->getMessage()]);
            exit;
        }
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
$productFetcher = new ProductFetcher();
$products = $productFetcher->fetchProducts($category);
echo json_encode($products);
?>
