<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $product_id = $_POST['product_id'];
    $user_name = $_POST['user_name'];
    $comment = $_POST['comment'];
    $rating = $_POST['rating'];

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
        echo 'Erreur de connexion à la base de données: ' . $e->getMessage();
        exit;
    }

    // Préparer et exécuter la requête d'insertion
    $query = 'INSERT INTO reviews (product_id, user_name, comment, rating) VALUES (?, ?, ?, ?)';
    $stmt = $pdo->prepare($query);
    $stmt->execute([$product_id, $user_name, $comment, $rating]);

    // Redirection vers la page des détails du produit après l'ajout de l'avis
    header("Location: details.php?id=$product_id");
    exit;
} else {
    // Redirection vers la page d'accueil si le formulaire n'a pas été soumis directement
    header("Location: index.html");
    exit;
}
?>
