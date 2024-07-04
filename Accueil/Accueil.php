<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nike</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="Accueil.css">
    <style>
        .login_link {
            position: relative;
            display: inline-block;
        }
        .login_link .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            right: 20px;
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
        .autocomplete-results {
            position: absolute;
            background-color: white;
            border: 1px solid #ccc;
            width: 250px;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 5px;
        }
        .autocomplete-results p {
            padding: 10px;
            margin: 0;
            cursor: pointer;
            font-size: 14px;
        }
        .autocomplete-results p:hover {
            background-color: #f1f1f1;
        }
        #product-search {
            width: 200px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 20px;
            outline: none;
            transition: width 0.4s ease-in-out;
        }
        #product-search:focus {
            width: 300px;
            border-color: #007bff;
        }
        .nav-part-2 {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .ri-search-line {
            position: absolute;
            margin-left: 15px;
            font-size: 20px;
            color: #888;
        }
        #product-search {
            padding-left: 35px;
            position: relative;
        }
        .content-right {
            display: flex;
            padding: 110px 100px;
            overflow-x: auto;
            overflow-y: hidden;
            max-height: calc(100vh - 200px);
        }
        .product {
            flex: 0 0 auto;
            width: 250px;
            white-space: normal;
            margin-right: 20px;
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
        <div class="just_do_it">
            <p>Just Do It</p>
        </div>
    </div>

    <div class="main">
        <div class="nav">
            <div class="nav-part-1">
                <img src="images/nike-logo-0.png" alt="logo">
                <ul>
                    <li><a href="../Boutique/Boutique.php" class="link">Tous</a></li>
                    <li><a href="../Boutique/Boutique.php?category=chaussure" class="link">Chaussures</a></li>
                    <li><a href="../Boutique/Boutique.php?category=vetement" class="link">Vêtements</a></li>
                    <li><a href="../Boutique/Boutique.php?category=sport" class="link">Sport</a></li>
                    <li><a href="../Panier/Panier.html" class="link">Mon Panier</a></li>
                </ul>
            </div>
            <div class="nav-part-2">
                <div style="position: relative;">
                    <i class="ri-search-line"></i>
                    <input type="text" id="product-search" placeholder="Rechercher des produits...">
                </div>
                <i class="ri-shopping-cart-2-line"></i>
                <i class="ri-menu-line"></i>
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
            </div>
        </div>
        <div class="content">
            <div class="content-left">
                <h5>Découvrez les éditions limitées</h5>
                <h1>Édition limitée Nike</h1>
                <p>Laissez l'extraordinaire s'exprimer. Rehaussez votre jeu avec l'Édition Limitée de Nike. Où l'innovation rencontre le style, laissant une empreinte durable. Just do it.</p>
                <a href="../Boutique/Boutique.php" class="btn">Acheter Maintenant !</a>
            </div>

            <div class="content-right">
                <div class="product" id="product-nike-air-max-1">
                    <img src="images/air-max-1-lx-shoes.png" alt="chaussures nike">
                    <h4>Nike Air max 1</h4>
                    <p class="catagory">Chaussures pour hommes</p>
                    <p class="color">Couleur : blanc</p>
                    <p class="price">124,99€</p>
                </div>
                <div class="product" id="product-nike-air-peg-2k5">
                    <img src="images/air-peg-2k5-shoes.png" alt="chaussures nike">
                    <h4>Nike Air peg 2K5</h4>
                    <p class="catagory">Chaussures pour hommes</p>
                    <p class="color">Couleur : blanc</p>
                    <p class="price">154,99€</p>
                </div>
                <div class="product" id="product-nike-lunar-roam">
                    <img src="images/lunar-roam-shoes.png" alt="chaussures nike">
                    <h4>Nike lunar roam</h4>
                    <p class="catagory">Chaussures pour hommes</p>
                    <p class="color">Couleur : bleu somnolent</p>
                    <p class="price">170,99€</p>
                </div>
                <div class="product" id="product-nike-nocta-glide">
                    <img src="images/nocta-glide-shoes.png" alt="chaussures nike">
                    <h4>Nike nocta glide</h4>
                    <p class="catagory">Chaussures pour hommes</p>
                    <p class="color">Couleur : blanc</p>
                    <p class="price">134,99€</p>
                </div>
                <div class="product" id="product-nike-terminator-high">
                    <img src="images/terminator-high-shoes.png" alt="chaussures nike">
                    <h4>Nike Terminator high</h4>
                    <p class="catagory">Chaussures pour hommes</p>
                    <p class="color">Couleur : bleu somnolent</p>
                    <p class="price">234,99€</p>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('product-search');

            searchInput.addEventListener('input', () => {
                const query = searchInput.value.trim().toLowerCase();
                filterProducts(query);
            });

            function filterProducts(query) {
                const products = document.querySelectorAll('.product');
                let anyVisible = false; // Flag to check if any product is visible
                products.forEach(product => {
                    const title = product.querySelector('h4').textContent.toLowerCase();
                    if (title.includes(query)) {
                        product.style.display = 'block';
                        anyVisible = true; // At least one product is visible
                    } else {
                        product.style.display = 'none';
                    }
                });

                // Show all products if query is empty
                if (query === "") {
                    products.forEach(product => {
                        product.style.display = 'block';
                    });
                    anyVisible = true; // Since all products are now visible
                }

                // Show a message if no products are found
                const contentRight = document.querySelector('.content-right');
                let noResultsMessage = document.querySelector('.no-results');
                if (!anyVisible) {
                    if (!noResultsMessage) {
                        noResultsMessage = document.createElement('div');
                        noResultsMessage.className = 'no-results';
                        noResultsMessage.textContent = 'Aucun produit trouvé';
                        contentRight.appendChild(noResultsMessage);
                    }
                } else {
                    if (noResultsMessage) {
                        noResultsMessage.remove();
                    }
                }
            }
        });
    </script>
</body>
</html>
