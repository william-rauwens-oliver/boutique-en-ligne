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
            position: relative;
            padding-left: 35px;
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
        .product a {
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .product .description {
            margin-top: 10px;
            font-size: 14px;
            color: #666;
            margin-top: 290px;
        }

    </style>
</head>
<body>

<?php
session_start();
$isLoggedIn = isset($_SESSION['username']);
$username = $isLoggedIn ? $_SESSION['username'] : '';

require_once 'db.php';

?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('product-search');

        searchInput.addEventListener('input', () => {
            const query = searchInput.value.trim().toLowerCase();
            filterProducts(query);
        });

        function filterProducts(query) {
            const products = document.querySelectorAll('.product');
            let anyVisible = false;
            products.forEach(product => {
                const title = product.querySelector('h4').textContent.toLowerCase();
                if (title.includes(query)) {
                    product.style.display = 'block';
                    anyVisible = true; 
                } else {
                    product.style.display = 'none';
                }
            });

            if (query === "") {
                products.forEach(product => {
                    product.style.display = 'block';
                });
                anyVisible = true; 
            }

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

        function loadProducts(category) {
            fetch(`../Boutique/GetBoutique.php?category=${category}`)
                .then(response => response.json())
                .then(products => {
                    const contentRight = document.querySelector('.content-right');
                    contentRight.innerHTML = '';

                    products.forEach(product => {
                        const productElement = `
                            <div class="product">
                                <a href="../Boutique/details.php?id=${product.id}">
                                    <img src="${product.image}" alt="${product.name}">
                                    <h4>${product.name}</h4>
                                    <p class="description">${product.description}</p>
                                    <p class="price">${product.price}€</p>
                                </a>
                            </div>
                        `;
                        contentRight.insertAdjacentHTML('beforeend', productElement);
                    });

                    const query = searchInput.value.trim().toLowerCase();
                    filterProducts(query);
                })
                .catch(error => {
                    console.error('Erreur lors du chargement des produits:', error);
                });
        }

        loadProducts('all');

        const navLinks = document.querySelectorAll('.nav-part-1 a');
        navLinks.forEach(link => {
            link.addEventListener('click', event => {
                event.preventDefault();
                const category = link.getAttribute('href').split('=')[1];
                loadProducts(category);
            });
        });
    });
</script>

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
            <img src="../Assets/images/nike-logo-0.png" alt="logo">
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

        </div>
    </div>
</div>

</body>
</html>
