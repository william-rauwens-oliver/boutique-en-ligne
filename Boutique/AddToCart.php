<?php
require_once 'db.php';

class AddPanier
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->pdo = $pdo;
    }

    public function ajouterProduit($productId)
    {
        if (!isset($_SESSION['user_id'])) {
            return json_encode(array('success' => false, 'error' => 'Utilisateur non connecté.'));
        }

        $userId = $_SESSION['user_id'];

        $stmt = $this->pdo->prepare("INSERT INTO panier (product_id, users_id) VALUES (?, ?)");
        if (!$stmt) {
            return json_encode(array('success' => false, 'error' => 'Erreur de préparation de la requête.'));
        }

        $stmt->execute([$productId, $userId]);

        if ($stmt->rowCount() > 0) {
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = array();
            }
            $_SESSION['cart'][] = $productId;

            $response = array('success' => true);
        } else {
            $response = array('success' => false, 'error' => 'Erreur lors de l\'ajout au panier.');
        }

        $stmt->closeCursor();

        return json_encode($response);
    }
}

if (isset($_POST['productId'])) {
    $productId = $_POST['productId'];
    $panier = new AddPanier($pdo);
    echo $panier->ajouterProduit($productId);
} else {
    echo json_encode(array('success' => false, 'error' => 'ID du produit non spécifié.'));
}
?>
