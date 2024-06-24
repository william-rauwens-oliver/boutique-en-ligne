<?php
session_start();

// Vérifiez si la session de l'utilisateur contient des articles dans le panier
if (isset($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
    $cartCount = count($cart);
} else {
    // Si le panier est vide ou n'existe pas
    $cartCount = 0;
}

// Retournez le nombre d'articles en format JSON
echo json_encode(['count' => $cartCount]);
?>
