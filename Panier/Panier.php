<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="Panier.css">
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
        /* Ajoutez vos styles CSS ici */
        .cart-container {
            display: flex;
            justify-content: space-between;
        }
        .cart {
            flex: 1;
        }
        .total {
            flex: 1;
            text-align: right;
            margin-top: 20px;
        }
        .total button {
            background-color: #424442;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
        }
        .total button:hover {
            background-color: #767676;
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
            <img src="../Assets/BoutiqueIMG/6.png" alt="">
        </div>
        <div class="item_2">
            <img src="../Assets/BoutiqueIMG/logo.png" alt="">
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
                            <a href="../Boutique/Boutique.php" class="link">Tous</a>
                            <div class="link_border"></div>
                        </li>
                        <li>
                            <a href="../Boutique/Boutique.php?category=chaussure" class="link">Chaussures</a>
                            <div class="link_border"></div>
                        </li>
                        <li>
                            <a href="../Boutique/Boutique.php?category=vetement" class="link">Vêtements</a>
                            <div class="link_border"></div>
                        </li>
                        <li>
                            <a href="../Boutique/Boutique.php?category=sport" class="link">Sport</a>
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
                        </div>
                    <?php else: ?>
                        <a href="../Authentification/Authentification.html" class="link">S'identifier</a>
                    <?php endif; ?>
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
            <div class="cart-container">
                <div class="cart">
                    <h2>Votre Panier</h2>
                    <div class="shop-item-container" id="cart-items-container">
                        
                    </div>
                </div>
                <div class="total">
                    <h2>Total de la Commande</h2>
                    <p id="total-amount">0€</p>
                    <button id="validate-cart-button">Passer à la commande</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function myMenuFunction() {
            var navDropdownMenu = document.getElementById("navDropdownMenu");
            if (navDropdownMenu.className === "nav_dropdown_menu") {
                navDropdownMenu.className += " responsive";
            } else {
                navDropdownMenu.className = "nav_dropdown_menu";
            }
        }

        $(document).ready(function () {
            loadCartItems();

            function loadCartItems() {
                $.ajax({
                    url: 'GetCartItems.php',
                    method: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        $('#cart-items-container').empty();
                        console.log(response);

                        var cartHtml = '';
                        var totalAmount = 0;

                        if (response.length > 0) {
                            var uniqueProducts = {};

                            $.each(response, function (index, product) {
                                if (!uniqueProducts[product.id]) {
                                    uniqueProducts[product.id] = true;

                                    cartHtml += '<div class="shop-item-container">';
                                    cartHtml += '<div class="shoe-img-box">';
                                    cartHtml += '<img src="' + product.image + '" class="shoe-img">';
                                    cartHtml += '</div>';
                                    cartHtml += '<div class="cart-item-info">';
                                    cartHtml += '<h3>' + product.name + '</h3>';
                                    cartHtml += '<p>' + product.price + '€</p>';
                                    cartHtml += '<button onclick="removeFromCart(' + product.id + ')" class="cart-item-remove">Supprimer</button>';
                                    cartHtml += '</div>';
                                    cartHtml += '</div>';

                                    totalAmount += parseFloat(product.price);
                                }
                            });
                        } else {
                            cartHtml = '<p>Votre panier est vide.</p>';
                        }

                        $('#cart-items-container').html(cartHtml);
                        $('#total-amount').text(totalAmount.toFixed(2) + '€');
                    },
                    error: function (xhr, status, error) {
                        console.error('Erreur lors du chargement du panier :', error);
                    }
                });
            }

            window.removeFromCart = function (productId) {
                $.ajax({
                    url: 'RemoveFromCart.php',
                    method: 'POST',
                    data: {
                        productId: productId
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            alert('Produit supprimé du panier avec succès !');
                            loadCartItems();
                        } else {
                            alert('Erreur lors de la suppression du produit du panier : ' + response.error);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Erreur lors de la suppression du produit du panier :', error);
                    }
                });
            }

            $('#validate-cart-button').click(function () {
                window.location.href = 'Payment.php';
            });
        });
    </script>
</body>
</html>
