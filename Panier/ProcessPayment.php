<?php
require_once '../vendor/autoload.php';

\Stripe\Stripe::setApiKey('sk_test_51PVZNhLVIZdra2mGGzBdXvBMej3NCFBRu0KOOtxOogk1CwM4zaEouutMFQ0ymORrTMqjptLwPiMys9Ycuh8qx9Ka00Uz1SLmci');

class ProcessPayment
{
    public function handlePayment()
    {
        header('Content-Type: application/json');

        // Get the POST data
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        // Validate input data
        if (!isset($data['payment_method_id'])) {
            echo json_encode(['error' => 'Invalid payment method ID']);
            http_response_code(400);
            exit();
        }

        try {
            // Create a PaymentIntent with the order amount and currency
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => 1000, // Amount in cents (adjust as needed)
                'currency' => 'eur', // Currency (adjust as needed)
                'payment_method' => $data['payment_method_id'],
                'confirmation_method' => 'manual',
                'confirm' => true,
            ]);

            echo json_encode(['success' => true]);
        } catch (\Stripe\Exception\CardException $e) {
            // Display error on client
            echo json_encode(['error' => $e->getError()->message]);
            http_response_code(400);
        } catch (Exception $e) {
            // Catch other exceptions and display error
            echo json_encode(['error' => $e->getMessage()]);
            http_response_code(500);
        }
    }
}

// Instantiate the class and call the method to handle payment
$paymentProcessor = new ProcessPayment();
$paymentProcessor->handlePayment();
?>
