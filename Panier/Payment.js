document.addEventListener('DOMContentLoaded', async () => {
    var stripe = Stripe('pk_test_51PVZNhLVIZdra2mGPMc5o0fLHRjdr1YBkxcU3ng7Jf0KgRGOUq6ia47gbn09Ivti3ZlAxEuwfYJJlJL6IZcQAnOf00So0kx72i');
    var elements = stripe.elements();
    var card = elements.create('card');
    card.mount('#card-element');

    var form = document.getElementById('payment-form');

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const { paymentMethod, error } = await stripe.createPaymentMethod('card', card);

        if (error) {
            document.getElementById('card-errors').textContent = error.message;
        } else {
            fetch('ProcessPayment.php', {
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
                }
            }).catch((error) => {
                console.error('Erreur lors du paiement :', error);
            });
        }
    });
});
