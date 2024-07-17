<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class ProductDetails
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getProductDetails($productId)
    {
        try {
            $sql = "SELECT * FROM products WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $productId);
            $stmt->execute();

            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($product) {
                return ['success' => true, 'product' => $product];
            } else {
                return ['success' => false, 'error' => 'Produit non trouvé.'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'error' => 'Erreur de base de données: ' . $e->getMessage()];
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = 'localhost';
    $db = 'boutique';
    $user = 'root';
    $pass = 'root';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $productDetails = new ProductDetails($pdo);

        $productId = isset($_POST['id']) ? $_POST['id'] : null;

        if ($productId === null) {
            echo json_encode(['success' => false, 'error' => 'ID du produit manquant.']);
            exit;
        }

        $result = $productDetails->getProductDetails($productId);

        echo json_encode($result);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Erreur de connexion à la base de données: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Méthode non autorisée.']);
}
?>
