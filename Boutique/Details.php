<?php
// Récupérer l'ID du produit depuis l'URL
$id = $_GET['id'] ?? null;

if (!$id) {
    // Gérer le cas où l'ID n'est pas fourni
    echo 'ID de produit non spécifié.';
    exit;
}

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

// Préparer et exécuter la requête pour récupérer les détails du produit
$query = 'SELECT * FROM products WHERE id = ?';
$stmt = $pdo->prepare($query);
$stmt->execute([$id]);
$product = $stmt->fetch();

// Vérifier si le produit existe
if (!$product) {
    echo 'Produit non trouvé.';
    exit;
}

// Exemple de produits (à remplacer par la récupération réelle depuis la base de données)
$products = [
    [
        'id' => 1,
        'name' => 'Chaussures de course',
        'description' => 'Des chaussures confortables pour la course à pied.',
        'price' => 49.99,
        'image' => '../Assets/BoutiqueIMG/1.jpg',
    ],
    [
        'id' => 2,
        'name' => 'T-shirt sportif',
        'description' => 'Un t-shirt respirant idéal pour le sport.',
        'price' => 19.99,
        'image' => '../Assets/BoutiqueIMG/2.jpg',
    ],
    [
        'id' => 3,
        'name' => 'Short de bain',
        'description' => 'Un short de bain confortable et élégant.',
        'price' => 29.99,
        'image' => '../Assets/BoutiqueIMG/3.jpg',
    ],
];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Produit</title>
    <link rel="stylesheet" href="Details.css">
</head>
<body>
    <div class="body_items">
        <div class="item_1">
            <img src="../Assets/BoutiqueIMG/6.png" alt="">
        </div>
        <div class="item_2">
            <img src="../Assets/BoutiqueIMG/logo.png" alt="">
        </div>
        <div class="just_do_it">
            <p>Just
               Do
               It
            </p>
        </div>
    </div>   
    
    <div class="container">
        <nav>
            <div class="left_nav">
                <div class="nav_logo">
                    <a href="/index.html">
                        <img src="../Assets/BoutiqueIMG/logo.png" alt="Logo de votre boutique">
                    </a>
                </div>
                <div class="nav_menu">
                    <ul>
                        <li>
                            <a href="#" class="link" data-category="all">Tous</a>
                            <div class="link_border"></div>
                        </li>
                        <li>
                            <a href="#" class="link" data-category="chaussure">Chaussures</a>
                            <div class="link_border"></div>
                        </li>
                        <li>
                            <a href="#" class="link" data-category="Vêtement">Vêtements</a>
                            <div class="link_border"></div>
                        </li>
                        <li>
                            <a href="#" class="link" data-category="sport">Sport</a>
                            <div class="link_border"></div>
                        </li>
                        <li>
                            <a href="../Panier/Panier.html" class="link">Mon Panier</a>
                            <div class="link_border"></div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="left_nav">
                <div class="login_link">
                    <a href="../Authentification/Authentification.html" class="link">S'identifier</a>
                    <div class="link_border"></div>
                </div>
                <div class="dropdown">
                    <div class="menu_bars" onclick="myMenuFunction()">
                        <div class="menu_bars_btn">
                            <img src="../Assets/BoutiqueIMG/bar.png" class="bar_1">
                            <img src="../Assets/BoutiqueIMG/bar.png" class="bar_2">
                        </div>
                        <div class="nav_dropdown_menu" id="navDropdownMenu">
                            <ul>
                                <li>
                                    <a href="#" class="link" data-category="all">HOME</a>
                                    <div class="link_border"></div>
                                </li>
                                <li>
                                    <a href="#" class="link" data-category="kids">KIDS</a>
                                    <div class="link_border"></div>
                                </li>
                                <li>
                                    <a href="#" class="link" data-category="men">MEN</a>
                                    <div class="link_border"></div>
                                </li>
                                <li>
                                    <a href="#" class="link" data-category="women">WOMEN</a>
                                    <div class="link_border"></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <div class="main">
            <div class="left_col">
                <div class="shoe_title">
                    <p><?php echo htmlspecialchars($product['name']); ?></p>
                </div>
                <div class="line">
                    <hr>
                </div>
                <div class="shoe_description">
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                </div>
                <div class="cart">
                    <button class="cart_btn" onclick="addToCart(<?php echo $product['id']; ?>)">Ajouter au panier</button>
                    <p class="price"><?php echo htmlspecialchars($product['price']); ?>€</p>
                </div>
            </div>
            <div class="right_col">
                <img src="<?php echo htmlspecialchars($product['image']); ?>" class="featured_img" alt="<?php echo htmlspecialchars($product['name']); ?>">
                <div class="shopping_cart_btn">
                    <a href="../Panier/Panier.html" class="shopping_cart_link">
                        <i class="bx bx-cart"></i>  
                        <span id="cart-count">0</span> <!-- Nombre d'articles dans le panier -->
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="details.js" defer></script>
    <script>
        function myMenuFunction() {
            var i = document.getElementById("navDropdownMenu");
            if (i.className === "nav_dropdown_menu") {
                i.className += " responsive";
            } else {
                i.className = "nav_dropdown_menu";
            }
        }
    </script>
</body>
</html>
