<?php

class AddPanier
{
    private $dbHost = 'localhost';
    private $dbUser = 'root';
    private $dbPass = 'root';
    private $dbName = 'boutique';
    private $conn;

    public function __construct()
    {
        // Démarrez la session si ce n'est pas déjà fait
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Connexion à la base de données
        $this->conn = new mysqli($this->dbHost, $this->dbUser, $this->dbPass, $this->dbName);

        // Vérifiez la connexion
        if ($this->conn->connect_error) {
            die("Erreur de connexion à la base de données : " . $this->conn->connect_error);
        }
    }

    public function __destruct()
    {
        // Fermez la connexion à la base de données
        if ($this->conn) {
            $this->conn->close();
        }
    }

    public function ajouterProduit($productId)
    {
        // Vérifiez si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            return json_encode(array('success' => false, 'error' => 'Utilisateur non connecté.'));
        }

        $userId = $_SESSION['user_id']; // Récupère l'ID utilisateur depuis la session

        // Préparez la requête pour insérer dans la table panier
        $stmt = $this->conn->prepare("INSERT INTO panier (product_id, users_id) VALUES (?, ?)");
        if (!$stmt) {
            return json_encode(array('success' => false, 'error' => 'Erreur de préparation de la requête.'));
        }

        $stmt->bind_param("ii", $productId, $userId);

        // Exécutez la requête
        if ($stmt->execute()) {
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
        $stmt->close();

        return json_encode($response);
    }
}

// Vérifiez si l'ID du produit est reçu en POST
if (isset($_POST['productId'])) {
    $productId = $_POST['productId'];
    $panier = new AddPanier();
    echo $panier->ajouterProduit($productId);
} else {
    // Répondez avec erreur si l'ID du produit n'est pas reçu
    echo json_encode(array('success' => false, 'error' => 'ID du produit non spécifié.'));
}
?>
