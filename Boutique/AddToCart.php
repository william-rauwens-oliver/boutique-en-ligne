<?php
require_once 'db.php';

class AddPanier
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        // Démarrez la session si ce n'est pas déjà fait
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->pdo = $pdo;
    }

    public function ajouterProduit($productId)
    {
        // Vérifiez si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            return json_encode(array('success' => false, 'error' => 'Utilisateur non connecté.'));
        }

        $userId = $_SESSION['user_id']; // Récupère l'ID utilisateur depuis la session

        // Préparez la requête pour insérer dans la table panier
        $stmt = $this->pdo->prepare("INSERT INTO panier (product_id, users_id) VALUES (?, ?)");
        if (!$stmt) {
            return json_encode(array('success' => false, 'error' => 'Erreur de préparation de la requête.'));
        }

        $stmt->execute([$productId, $userId]);

        // Vérifiez si l'insertion a réussi
        if ($stmt->rowCount() > 0) {
            // Ajoutez le produit à la session de panier
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = array();
            }
            $_SESSION['cart'][] = $productId;

            // Répondez avec succès en JSON
            $response = array('success' => true);
        } else {
            // Répondez avec erreur si l'insertion a échoué
            $response = array('success' => false, 'error' => 'Erreur lors de l\'ajout au panier.');
        }

        // Fermez la déclaration
        $stmt->closeCursor();

        return json_encode($response);
    }
}

// Vérifiez si l'ID du produit est reçu en POST
if (isset($_POST['productId'])) {
    $productId = $_POST['productId'];
    $panier = new AddPanier($pdo);
    echo $panier->ajouterProduit($productId);
} else {
    // Répondez avec erreur si l'ID du produit n'est pas reçu
    echo json_encode(array('success' => false, 'error' => 'ID du produit non spécifié.'));
}
?>
