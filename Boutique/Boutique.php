<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boutique</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="Boutique.css">
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
    <?php
    session_start();
    $isLoggedIn = isset($_SESSION['username']);
    $username = $isLoggedIn ? $_SESSION['username'] : '';
    ?>

    <div class="body_items">
        <div class="item_1">
            <img src="../Assets/BoutiqueIMG/6.png" alt="Image 6">
        </div>
        <div class="item_2">
            <img src="../Assets/BoutiqueIMG/logo.png" alt="Logo">
        </div>
        <div class="just_do_it">
            <p>Just Do It</p>
        </div>
    </div>
    <div class="container">
        <nav>
            <div class="left_nav">
                <div class="nav_logo">
                    <a href="../Accueil/Accueil.php">
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
                            <a href="../Panier/Panier.php" class="link">Mon Panier</a>
                            <div class="link_border"></div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="right_nav">
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
                <div class="shoe_title">
                    <p>Nike</p>
                </div>
                <div class="line">
                    <hr>
                </div>
                <div class="shoe_description">
                    <p>Nike est la meilleure marque de vêtements</p>
                </div>
                <div class="products-grid" id="products-container">
                    <!-- Produits dynamiques -->
                </div>
            </div>
            <div class="right_col">
                <div class="shopping_cart_btn">
                    <a href="../Panier/Panier.php" class="shopping_cart_link">
                        <i class="bx bx-cart"></i>
                        <span id="cart-count">0</span> <!-- Nombre d'articles dans le panier -->
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="Boutique.js" defer></script>
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
