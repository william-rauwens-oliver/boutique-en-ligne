<?php
require_once '../vendor/autoload.php';

\Stripe\Stripe::setApiKey('sk_test_51PVZNhLVIZdra2mGGzBdXvBMej3NCFBRu0KOOtxOogk1CwM4zaEouutMFQ0ymORrTMqjptLwPiMys9Ycuh8qx9Ka00Uz1SLmci');

header('Content-Type: application/json');

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!isset($data['payment_method_id'])) {
    echo json_encode(['error' => 'Invalid payment method ID']);
    http_response_code(400);
    exit();
}

try {
    $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => 1000,
        'currency' => 'eur',
        'payment_method' => $data['payment_method_id'],
        'confirmation_method' => 'manual',
        'confirm' => true,
    ]);

    echo json_encode(['success' => true]);
} catch (\Stripe\Exception\CardException $e) {
    echo json_encode(['error' => $e->getError()->message]);
    http_response_code(400);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
    http_response_code(500);
}
?>
