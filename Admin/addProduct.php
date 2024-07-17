<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'db.php';

class AddProducts
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function addProduct($name, $description, $price, $category, $image)
    {
        try {
            $sql = 'INSERT INTO products (name, description, price, category, image) VALUES (?, ?, ?, ?, ?)';
            $stmt = $this->pdo->prepare($sql);

            if ($stmt->execute([$name, $description, $price, $category, $image])) {
                return ['status' => 'success'];
            } else {
                return ['status' => 'error', 'message' => 'Failed to add product'];
            }
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=boutique", "root", "root");
        $addProductsService = new AddProducts($pdo);

        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $image = $_POST['image'];

        $result = $addProductsService->addProduct($name, $description, $price, $category, $image);
        
        header('Content-Type: application/json');
        echo json_encode($result);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Erreur de connexion à la base de données: ' . $e->getMessage()]);
    }
}
?>
