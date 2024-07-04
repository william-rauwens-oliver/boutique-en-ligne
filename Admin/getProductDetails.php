<?php
// Inclusion des fichiers nécessaires
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Classe pour gérer les détails des produits
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
            // Prépare la requête SQL pour récupérer les détails du produit
            $sql = "SELECT * FROM products WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $productId);
            $stmt->execute();

            // Récupère le résultat de la requête
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

// Si la méthode de la requête est POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Connexion à la base de données
    $host = 'localhost';
    $db = 'boutique';
    $user = 'root';
    $pass = 'root';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Création de l'instance de la classe ProductDetails
        $productDetails = new ProductDetails($pdo);

        // Vérifie si l'ID du produit est passé en POST
        $productId = isset($_POST['id']) ? $_POST['id'] : null;

        if ($productId === null) {
            echo json_encode(['success' => false, 'error' => 'ID du produit manquant.']);
            exit;
        }

        // Appel à la méthode getProductDetails pour récupérer les détails du produit
        $result = $productDetails->getProductDetails($productId);

        // Renvoie le résultat au format JSON
        echo json_encode($result);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Erreur de connexion à la base de données: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Méthode non autorisée.']);
}
?>
