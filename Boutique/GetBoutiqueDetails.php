<?php
header('Content-Type: application/json');

$host = 'localhost';
$db   = 'boutique';
$user = 'root';
$pass = 'willy';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Erreur de connexion à la base de données: ' . $e->getMessage()]);
    exit;
}

$productId = $_GET['id'] ?? null;

if (!$productId) {
    echo json_encode(['error' => 'ID du produit manquant']);
    exit;
}

try {
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$productId]);
    $product = $stmt->fetch();

    if ($product) {
        echo json_encode($product);
    } else {
        echo json_encode(['error' => 'Produit non trouvé']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Erreur lors de la récupération des détails du produit: ' . $e->getMessage()]);
}
?>
