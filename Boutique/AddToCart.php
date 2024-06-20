<?php
// Initialisez la session si ce n'est pas déjà fait
session_start();

// Vérifiez si l'ID du produit est reçu en POST
if (isset($_POST['productId'])) {
    $productId = $_POST['productId'];

    // Connexion à la base de données (exemple avec MySQLi)
    $conn = new mysqli('localhost', 'root', 'root', 'boutique');

    // Vérifiez la connexion
    if ($conn->connect_error) {
        die("Erreur de connexion à la base de données : " . $conn->connect_error);
    }

    // Préparez la requête pour insérer dans la table panier
    $stmt = $conn->prepare("INSERT INTO panier (product_id) VALUES (?)");
    $stmt->bind_param("i", $productId);

    // Exécutez la requête
    if ($stmt->execute()) {
        // Ajoutez le produit à la session de panier
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }
        $_SESSION['cart'][] = $productId;

        // Répondez avec succès en JSON
        echo json_encode(array('success' => true));
    } else {
        // Répondez avec erreur si l'insertion a échoué
        echo json_encode(array('success' => false, 'error' => 'Erreur lors de l\'ajout au panier.'));
    }

    // Fermez la connexion et la déclaration
    $stmt->close();
    $conn->close();
} else {
    // Répondez avec erreur si l'ID du produit n'est pas reçu
    echo json_encode(array('success' => false, 'error' => 'ID du produit non spécifié.'));
}
?>
