<?php
// Simule une connexion à la base de données
$conn = new mysqli('localhost', 'root', 'willy', 'boutique');

if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
}

// Fonction pour récupérer tous les produits
function getProducts() {
    $products = array(
        array(
            'id' => 1,
            'name' => 'Smartphone XYZ',
            'category' => 'electronique',
            'image' => 'https://example.com/smartphone-xyz.jpg',
            'price' => 599.99,
            'description' => 'Un smartphone avancé avec de nombreuses fonctionnalités.'
        ),
        array(
            'id' => 2,
            'name' => 'Chemise rayée',
            'category' => 'vetements',
            'image' => 'https://example.com/chemise-rayee.jpg',
            'price' => 39.99,
            'description' => 'Chemise pour hommes, style décontracté, matériau confortable.'
        )
    );

    return $products;
}

// Fonction pour récupérer les détails d'un produit par son ID
function getProductDetails($productId) {
    $products = getProducts();

    foreach ($products as $product) {
        if ($product['id'] == $productId) {
            return $product;
        }
    }

    return null; // Retourne null si le produit n'est pas trouvé
}
?>
