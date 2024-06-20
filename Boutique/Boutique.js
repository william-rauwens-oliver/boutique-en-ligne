// Définissez la fonction addToCart en dehors de $(document).ready()
function addToCart(productId) {
    $.ajax({
        url: 'AddToCart.php',
        method: 'POST',
        data: { productId: productId },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                alert('Produit ajouté au panier avec succès !');
            } else {
                alert('Erreur lors de l\'ajout au panier : ' + response.error);
            }
        },
        error: function(xhr, status, error) {
            console.error('Erreur lors de l\'ajout au panier : ' + error);
        }
    });
}

// Assurez-vous que le code à l'intérieur de $(document).ready() reste tel quel
$(document).ready(function() {
    loadProducts();

    function loadProducts() {
        $.ajax({
            url: 'GetBoutique.php',
            method: 'GET',
            dataType: 'json',
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
                        productsHtml += '<div class="add_to_shop" onclick="addToCart(' + product.id + ')">';
                        productsHtml += '<i class="bx bx-cart" data-id="' + product.id + '"></i>';
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
