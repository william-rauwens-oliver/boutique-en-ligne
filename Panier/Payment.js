document.addEventListener('DOMContentLoaded', async () => {
    var stripe = Stripe('pk_test_51PVZNhLVIZdra2mGPMc5o0fLHRjdr1YBkxcU3ng7Jf0KgRGOUq6ia47gbn09Ivti3ZlAxEuwfYJJlJL6IZcQAnOf00So0kx72i'); // Remplacez par votre clé publique Stripe
    var elements = stripe.elements();
    var card = elements.create('card');
    card.mount('#card-element');

    var form = document.getElementById('payment-form');

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const { paymentMethod, error } = await stripe.createPaymentMethod('card', card);

        if (error) {
            // Display error.message in your UI.
            document.getElementById('card-errors').textContent = error.message;
        } else {
            // Send paymentMethod.id to your server.
            fetch('create_payment_intent.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    payment_method_id: paymentMethod.id,
                }),
            }).then((result) => {
                return result.json();
            }).then((data) => {
                if (data.error) {
                    document.getElementById('card-errors').textContent = data.error;
                } else {
                    alert('Paiement réussi !');
                    // Vous pouvez maintenant vider le panier et rediriger l'utilisateur vers une page de confirmation
                }
            });
        }
    });
});
