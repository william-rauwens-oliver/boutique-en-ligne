$(document).ready(function() {

    loadProducts();

    $('#product-form').submit(function(e) {
        e.preventDefault();

        let productId = $('#product-id').val();
        let name = $('#name').val();
        let description = $('#description').val();
        let price = $('#price').val();
        let category = $('#category').val();
        let image = $('#image').val();

        if (productId) {
            editProduct(productId, name, description, price, category, image);
        } else {
            addProduct(name, description, price, category, image);
        }
    });

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

                $('.edit-btn').click(function() {
                    let productId = $(this).data('id');
                    fetchProductDetails(productId);
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

    function fetchProductDetails(productId) {
        $.ajax({
            url: 'getProductDetails.php',
            method: 'POST',
            data: { id: productId },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#product-id').val(response.product.id);
                    $('#name').val(response.product.name);
                    $('#description').val(response.product.description);
                    $('#price').val(response.product.price);
                    $('#category').val(response.product.category);
                    $('#image').val(response.product.image);

                    $('#submit-button').text('Modifier le produit');
                } else {
                    alert('Erreur lors de la récupération des détails du produit à éditer: ' + response.error);
                }
            },
            error: function(error) {
                console.error('Erreur lors de la récupération des détails du produit à éditer:', error);
            }
        });
    }

    function editProduct(productId, name, description, price, category, image) {
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
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert('Produit modifié avec succès');
                } else {
                    alert('Erreur lors de la modification du produit: ' + response.message);
                }
                loadProducts();
                $('#product-form')[0].reset();
                $('#product-id').val('');
                $('#submit-button').text('Ajouter le produit');
            },
            error: function(error) {
                console.error('Erreur lors de la modification du produit:', error);
            }
        });
    }

    function addProduct(name, description, price, category, image) {
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
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert('Produit ajouté avec succès');
                } else {
                    alert('Erreur lors de l\'ajout du produit: ' + response.message);
                }
                loadProducts();
                $('#product-form')[0].reset();
            },
            error: function(error) {
                console.error('Erreur lors de l\'ajout du produit:', error);
            }
        });
    }

    function deleteProduct(productId) {
        if (confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')) {
            $.ajax({
                url: 'deleteProduct.php',
                method: 'POST',
                data: { id: productId },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        alert('Produit supprimé avec succès');
                    } else {
                        alert('Erreur lors de la suppression du produit: ' + response.message);
                    }
                    loadProducts();
                },
                error: function(error) {
                    console.error('Erreur lors de la suppression du produit:', error);
                }
            });
        }
    }
});
