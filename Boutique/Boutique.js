$(document).ready(function() {
    // Chargement initial des produits
    loadProducts();

    // Fonction pour charger les produits depuis la base de données
    function loadProducts() {
        $.ajax({
            url: 'GetBoutique.php', // L'url doit correspondre à votre script PHP pour charger les produits
            method: 'GET',
            dataType: 'json', // Indique que la réponse doit être traitée comme du JSON
            success: function(response) {
                if (response.error) {
                    console.error('Erreur: ' + response.error);
                } else {
                    var productsHtml = '';
                    $.each(response, function(index, product) {
                        productsHtml += '<div class="shop_item_container">';
                        productsHtml += '<div class="shoe_img_box">';
                        productsHtml += '<img src="' + product.image + '" class="shoe_img">';
                        productsHtml += '</div>';
                        productsHtml += '<div class="shoe_name_price">';
                        productsHtml += '<h3>' + product.name + '</h3>';
                        productsHtml += '<p>' + product.price + '€</p>';
                        productsHtml += '</div>';
                        productsHtml += '<div class="add_to_shop">';
                        productsHtml += '<i class="bx bx-cart"></i>';
                        productsHtml += '</div>';
                        productsHtml += '</div>';
                    });
                    $('#products-container').html(productsHtml);
                }
            },
            error: function(xhr, status, error) {
                console.error('Erreur lors du chargement des produits:', error);
            }
        });
    }
});
