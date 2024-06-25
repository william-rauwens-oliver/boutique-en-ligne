$(document).ready(function() {
    // Charger les produits au démarrage
    loadProducts();

    // Ajouter ou modifier un produit
    $('#product-form').submit(function(e) {
        e.preventDefault();

        let productId = $('#product-id').val();
        let name = $('#name').val();
        let description = $('#description').val();
        let price = $('#price').val();
        let category = $('#category').val();
        let image = $('#image').val();

        if (productId) {
            // Modifier un produit
            $.ajax({
                url: 'editProduct.php',
                method: 'POST',
                data: {
                    id: productId,
                    name: name,
                    description: description,
                    price: price,
                    category: category,
                    image: image
                },
                success: function(response) {
                    alert('Produit modifié avec succès');
                    loadProducts();
                    $('#product-form')[0].reset();
                    $('#product-id').val('');
                    $('#submit-button').text('Ajouter le produit');
                },
                error: function(error) {
                    console.error('Erreur lors de la modification du produit:', error);
                }
            });
        } else {
            // Ajouter un produit
            $.ajax({
                url: 'addProduct.php',
                method: 'POST',
                data: {
                    name: name,
                    description: description,
                    price: price,
                    category: category,
                    image: image
                },
                success: function(response) {
                    alert('Produit ajouté avec succès');
                    loadProducts();
                    $('#product-form')[0].reset();
                },
                error: function(error) {
                    console.error('Erreur lors de l\'ajout du produit:', error);
                }
            });
        }
    });

    // Charger les produits
    function loadProducts() {
        $.ajax({
            url: 'getProducts.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                let productsHtml = '';
                $.each(response, function(index, product) {
                    productsHtml += '<tr>';
                    productsHtml += '<td>' + product.id + '</td>';
                    productsHtml += '<td>' + product.name + '</td>';
                    productsHtml += '<td>' + product.description + '</td>';
                    productsHtml += '<td>' + product.price + '€</td>';
                    productsHtml += '<td>' + product.category + '</td>';
                    productsHtml += '<td><img src="' + product.image + '" alt="' + product.name + '" style="width:50px;height:50px;"></td>';
                    productsHtml += '<td class="actions">';
                    productsHtml += '<button class="edit-btn" data-id="' + product.id + '">Modifier</button>';
                    productsHtml += '<button class="delete-btn" data-id="' + product.id + '">Supprimer</button>';
                    productsHtml += '</td>';
                    productsHtml += '</tr>';
                });
                $('#products-table').html(productsHtml);

                // Ajouter les événements pour les boutons de modification et suppression
                $('.edit-btn').click(function() {
                    let productId = $(this).data('id');
                    editProduct(productId);
                });

                $('.delete-btn').click(function() {
                    let productId = $(this).data('id');
                    deleteProduct(productId);
                });
            },
            error: function(error) {
                console.error('Erreur lors du chargement des produits:', error);
            }
        });
    }

    // Modifier un produit
// Modifier un produit
function editProduct(productId) {
    $.ajax({
        url: 'editProduct.php', // Assurez-vous que le chemin est correct par rapport à votre structure de fichiers
        method: 'POST',
        data: {
            id: productId,
            name: $('#name').val(),
            description: $('#description').val(),
            price: $('#price').val(),
            category: $('#category').val(),
            image: $('#image').val()
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                alert('Produit modifié avec succès');
                loadProducts(); // Recharger la liste des produits après modification
                $('#product-form')[0].reset();
                $('#product-id').val('');
                $('#submit-button').text('Ajouter le produit');
            } else {
                alert('Erreur lors de la modification du produit: ' + response.error);
            }
        },
        error: function(error) {
            console.error('Erreur lors de la modification du produit:', error);
        }
    });
}

    // Supprimer un produit
    function deleteProduct(productId) {
        if (confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')) {
            $.ajax({
                url: 'deleteProduct.php',
                method: 'POST',
                data: { id: productId },
                success: function(response) {
                    alert('Produit supprimé avec succès');
                    loadProducts();
                },
                error: function(error) {
                    console.error('Erreur lors de la suppression du produit:', error);
                }
            });
        }
    }
});
