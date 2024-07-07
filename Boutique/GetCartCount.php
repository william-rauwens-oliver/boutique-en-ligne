<?php
class CartHandler
{
    public function __construct()
    {
        session_start();
    }

    public function getCartCount()
    {
        if (isset($_SESSION['cart'])) {
            $cart = $_SESSION['cart'];
            return count($cart);
        } else {
            return 0;
        }
    }

    public function respondWithCartCount()
    {
        $cartCount = $this->getCartCount();
        header('Content-Type: application/json');
        echo json_encode(['count' => $cartCount]);
    }
}

// Utilisation de la classe
$cartHandler = new CartHandler();
$cartHandler->respondWithCartCount();
?>
