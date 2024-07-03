<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class EditProducts
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function updateProduct($id, $name, $description, $price, $image, $category)
    {
        try {
            $sql = "UPDATE products SET name = :name, description = :description, price = :price, image = :image, category = :category WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':image', $image);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':id', $id);

            if ($stmt->execute()) {
                return ['success' => true];
            } else {
                return ['success' => false, 'error' => 'Erreur lors de la mise à jour du produit.'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'error' => 'Erreur de connexion à la base de données: ' . $e->getMessage()];
        }
    }
}

// Exemple d'utilisation :
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $host = 'localhost';
    $db = 'boutique';
    $user = 'root';
    $pass = 'root';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
        $editProducts = new EditProducts($pdo);

        // Récupération des données envoyées par le formulaire
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $name = isset($_POST['name']) ? $_POST['name'] : null;
        $description = isset($_POST['description']) ? $_POST['description'] : null;
        $price = isset($_POST['price']) ? $_POST['price'] : null;
        $image = isset($_POST['image']) ? $_POST['image'] : null;
        $category = isset($_POST['category']) ? $_POST['category'] : null;

        // Appel à la méthode updateProduct de la classe EditProducts
        $result = $editProducts->updateProduct($id, $name, $description, $price, $image, $category);

        // Retourne le résultat de la mise à jour en JSON
        echo json_encode($result);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => 'Erreur de connexion à la base de données: ' . $e->getMessage()]);
    }
}
?>
