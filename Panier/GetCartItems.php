<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    $conn = new mysqli('localhost', 'root', 'root', 'boutique');

    if ($conn->connect_error) {
        die("Erreur de connexion à la base de données : " . $conn->connect_error);
    }

    $query = "SELECT p.id, p.name, p.price, p.image 
              FROM products p 
              INNER JOIN panier c ON p.id = c.product_id 
              WHERE c.users_id = ?
              ORDER BY c.id";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    $cartItems = array();
    while ($row = $result->fetch_assoc()) {
        $product = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'price' => $row['price'],
            'image' => $row['image']
        );
        $cartItems[] = $product;
    }

    $stmt->close();
    $conn->close();

    header('Content-Type: application/json');
    echo json_encode($cartItems);
} else {

    echo json_encode(array());
}
?>
