<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $stock = $_POST['stock'];
    $image = $_POST['image'];

    $sql = 'INSERT INTO products (name, price, category, stock, image) VALUES (?, ?, ?, ?, ?)';
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$name, $price, $category, $stock, $image])) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add product']);
    }
}
?>
