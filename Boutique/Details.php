<?php
require_once 'ProductDetailsHandler.php';

// Utilisation de la connexion PDO depuis db.php
$productHandler = new ProductDetailsHandler($pdo);
list($product, $reviews) = $productHandler->handleRequest();

session_start();
$isLoggedIn = isset($_SESSION['username']);
$username = $isLoggedIn ? $_SESSION['username'] : '';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Produit</title>
    <link rel="stylesheet" href="Details.css">
    <style>
        .login_link {
            position: relative;
            display: inline-block;
        }
        .login_link .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }
        .login_link .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }
        .login_link .dropdown-content a:hover {
            background-color: #f1f1f1;
        }
        .login_link:hover .dropdown-content {
            display: block;
        }
    </style>
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
                        <a href="Boutique.php" class="link" data-category="all">Tous</a>
                        <div class="link_border"></div>
                    </li>
                    <li>
                        <a href="Boutique.php" class="link" data-category="chaussure">Chaussures</a>
                        <div class="link_border"></div>
                    </li>
                    <li>
                        <a href="Boutique.php" class="link" data-category="Vêtement">Vêtements</a>
                        <div class="link_border"></div>
                    </li>
                    <li>
                        <a href="Boutique.php" class="link" data-category="sport">Sport</a>
                        <div class="link_border"></div>
                    </li>
                    <li>
                        <a href="./Panier/Panier.html" class="link">Mon Panier</a>
                        <div class="link_border"></div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="left_nav">
            <div class="login_link">
                <?php if ($isLoggedIn): ?>
                    <a href="#" class="link"><?php echo htmlspecialchars($username); ?></a>
                    <div class="dropdown-content">
                        <a href="../Authentification/logout.php" class="link">Se déconnecter</a>
                        <a href="../MesCommandes/MesCommandes.html" class="link">Mes commandes</a>
                    </div>
                <?php else: ?>
                    <a href="../Authentification/Authentification.html" class="link">S'identifier</a>
                <?php endif; ?>
                <div class="link_border"></div>
            </div>
            <div class="dropdown">
                <div class="menu_bars" onclick="myMenuFunction()">
                    <div class="menu_bars_btn">
                        <img src="../Assets/BoutiqueIMG/bar.png" class="bar_1" alt="Bar 1">
                        <img src="../Assets/BoutiqueIMG/bar.png" class="bar_2" alt="Bar 2">
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
            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
        </div>
        <div class="right_col">
            <div class="product-details">
                <h2 class="title"><?php echo htmlspecialchars($product['name']); ?></h2>
                <div class="price"><?php echo htmlspecialchars($product['price']); ?>€</div>
                <p class="description"><?php echo htmlspecialchars($product['description']); ?></p>
                <button class="cart_btn" onclick="addToCart(<?php echo $product['id']; ?>)">Ajouter au panier</button>
            </div>
            <div class="review-section">
                <h3>Avis des utilisateurs</h3>
                <?php if ($reviews && count($reviews) > 0): ?>
                    <ul class="reviews">
                        <?php foreach ($reviews as $review): ?>
                            <li>
                                <strong><?php echo htmlspecialchars($review['user_name']); ?></strong>
                                <div>Évaluation: <?php echo htmlspecialchars($review['rating']); ?>/5</div>
                                <p><?php echo htmlspecialchars($review['comment']); ?></p>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>Aucun avis pour le moment.</p>
                <?php endif; ?>
            </div>

            <!-- Boîte autour du formulaire pour ajouter un avis -->
            <div class="add-review-form-container">
                <h3>Ajouter un avis</h3>
                <div class="add-review-form">
                    <form action="add_review.php" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <input type="text" name="user_name" placeholder="Votre nom" required>
                        <textarea name="comment" placeholder="Votre avis" rows="4" required></textarea>
                        <select name="rating" required>
                            <option value="1">1 étoile</option>
                            <option value="2">2 étoiles</option>
                            <option value="3">3 étoiles</option>
                            <option value="4">4 étoiles</option>
                            <option value="5">5 étoiles</option>
                        </select>
                        <button type="submit">Ajouter un avis</button>
                    </form>
                </div>
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
