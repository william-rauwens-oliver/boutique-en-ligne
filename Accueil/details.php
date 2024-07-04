<?php
require_once 'db.php';
require_once 'ProductDetailsHandler.php';

// Initialise la classe ProductDetailsHandler avec la connexion PDO existante
$productHandler = new ProductDetailsHandler($pdo);

// Gère la requête pour récupérer les détails et les avis du produit
list($product, $reviews) = $productHandler->handleRequest();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Produit</title>
    <link rel="stylesheet" href="styles.css"> <!-- Incluez vos styles CSS -->
</head>
<body>
    <h1>Détails du Produit</h1>
    <div>
        <h2><?= htmlspecialchars($product['name']) ?></h2>
        <p><?= htmlspecialchars($product['category']) ?></p>
        <p>Couleur : <?= htmlspecialchars($product['color']) ?></p>
        <p>Prix : <?= htmlspecialchars($product['price']) ?>€</p>
        <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
    </div>

    <h2>Avis sur le Produit</h2>
    <ul>
        <?php foreach ($reviews as $review): ?>
            <li>
                <p><?= htmlspecialchars($review['user']) ?></p>
                <p><?= htmlspecialchars($review['comment']) ?></p>
                <p>Note : <?= htmlspecialchars($review['rating']) ?>/5</p>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
