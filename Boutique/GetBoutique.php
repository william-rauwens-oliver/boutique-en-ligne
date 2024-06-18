<?php
header('Content-Type: application/json');

// Connexion à la base de données
$host = 'localhost';
$db   = 'boutique';
$user = 'root';
$pass = 'root';
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

// Filtrage par catégorie
$category = $_GET['category'] ?? 'all';
$query = 'SELECT * FROM products';
$params = [];

if ($category !== 'all') {
    $query .= ' WHERE category = ?';
    $params[] = $category;
}

try {
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $products = $stmt->fetchAll();
    echo json_encode($products);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Erreur lors de la récupération des produits: ' . $e->getMessage()]);
}
?>
