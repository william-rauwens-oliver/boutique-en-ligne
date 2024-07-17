<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'db.php';

class Products
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getProducts($id = null)
    {
        if ($id !== null) {
            $sql = 'SELECT * FROM products WHERE id = ?';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            return $product ? [$product] : [];
        } else {
            $sql = 'SELECT * FROM products';
            $stmt = $this->pdo->query($sql);
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $products ?: [];
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=boutique", "root", "root");
        $productsService = new Products($pdo);

        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $products = $productsService->getProducts($id);
        } else {
            $products = $productsService->getProducts();
        }

        header('Content-Type: application/json');
        echo json_encode($products);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Erreur de connexion à la base de données: ' . $e->getMessage()]);
    }
}
?>
