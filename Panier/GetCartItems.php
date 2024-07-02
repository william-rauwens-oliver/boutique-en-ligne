<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $conn = new mysqli('localhost', 'root', 'root', 'boutique');

    if ($conn->connect_error) {
        die("Erreur de connexion à la base de données : " . $conn->connect_error);
    }

    $cartItems = array();
    
    $productIds = implode(",", $_SESSION['cart']);

    $query = "SELECT p.id, p.name, p.price, p.image 
              FROM products p 
              INNER JOIN panier c ON p.id = c.product_id 
              WHERE c.product_id IN ($productIds)
              ORDER BY FIELD(c.product_id, $productIds)";
              
    $result = $conn->query($query);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $product = array(
                'id' => $row['id'],
                'name' => $row['name'],
                'price' => $row['price'],
                'image' => $row['image']
            );
            $cartItems[] = $product;
        }
        $result->free();
    } else {
        die('Erreur lors de l\'exécution de la requête SQL : ' . $conn->error);
    }

    $conn->close();

    header('Content-Type: application/json');
    echo json_encode($cartItems);
} else {
    
    echo json_encode(array());
}
?>
