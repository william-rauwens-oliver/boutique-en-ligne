<?php
require 'vendor/autoload.php'; // Assurez-vous d'installer Stripe PHP library via Composer

\Stripe\Stripe::setApiKey('sk_test_51PVZNhLVIZdra2mGGzBdXvBMej3NCFBRu0KOOtxOogk1CwM4zaEouutMFQ0ymORrTMqjptLwPiMys9Ycuh8qx9Ka00Uz1SLmci'); // Remplacez par votre clé secrète Stripe

$input = file_get_contents('php://input');
$data = json_decode($input, true);

try {
    $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => 1000, // Montant en centimes
        'currency' => 'eur',
        'payment_method' => $data['payment_method_id'],
        'confirmation_method' => 'manual',
        'confirm' => true,
    ]);

    echo json_encode(['success' => true]);
} catch (\Stripe\Exception\CardException $e) {
    echo json_encode(['error' => $e->getError()->message]);
}
?>
