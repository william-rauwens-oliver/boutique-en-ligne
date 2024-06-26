document.addEventListener('DOMContentLoaded', function() {
    const featuredProducts = [
        { id: 1, name: 'Produit 1', image: 'img/product1.jpg', price: '29.99€' },
        { id: 2, name: 'Produit 2', image: 'img/product2.jpg', price: '39.99€' },
    ];

    const latestProducts = [
        { id: 3, name: 'Produit 3', image: 'img/product3.jpg', price: '19.99€' },
        { id: 4, name: 'Produit 4', image: 'img/product4.jpg', price: '49.99€' },
    ];

    const renderProducts = (products, containerId) => {
        const container = document.getElementById(containerId);
        products.forEach(product => {
            const productHtml = `
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="${product.image}" class="card-img-top" alt="${product.name}">
                        <div class="card-body">
                            <h5 class="card-title">${product.name}</h5>
                            <p class="card-text">${product.price}</p>
                        </div>
                    </div>
                </div>
            `;
            container.innerHTML += productHtml;
        });
    };

    renderProducts(featuredProducts, 'featured-products .row');
    renderProducts(latestProducts, 'latest-products .row');
});
