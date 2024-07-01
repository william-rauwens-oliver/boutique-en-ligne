<?php
session_start();

if (isset($_POST['productId'])) {
    $productId = $_POST['productId'];

    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $product) {
            if ($product['id'] == $productId) {
                unset($_SESSION['cart'][$key]);

                $_SESSION['cart'] = array_values($_SESSION['cart']);

                echo json_encode(['success' => true]);
                exit;
            }
        }
    }

    echo json_encode(['success' => false, 'error' => 'Produit non trouvé dans le panier.']);
} else {
    echo json_encode(['success' => false, 'error' => 'ID du produit non fourni.']);
}
?>
