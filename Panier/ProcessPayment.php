<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';

\Stripe\Stripe::setApiKey('sk_test_51PVZNhLVIZdra2mGGzBdXvBMej3NCFBRu0KOOtxOogk1CwM4zaEouutMFQ0ymORrTMqjptLwPiMys9Ycuh8qx9Ka00Uz1SLmci');

class ProcessPayment
{
    public function handlePayment()
    {
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

            $orderId = $this->saveOrderToDatabase($data);

            echo json_encode(['success' => true, 'order_id' => $orderId]);
        } catch (\Stripe\Exception\CardException $e) {
            echo json_encode(['error' => $e->getError()->message]);
            http_response_code(400);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
            http_response_code(500);
        }
    }

    private function saveOrderToDatabase($data)
    {
        $mysqli = new mysqli('localhost', 'root', 'root', 'boutique');

        if ($mysqli->connect_error) {
            die('Erreur de connexion à la base de données : ' . $mysqli->connect_error);
        }

        $firstName = $mysqli->real_escape_string($data['first_name']);
        $lastName = $mysqli->real_escape_string($data['last_name']);
        $address = $mysqli->real_escape_string($data['address']);
        $city = $mysqli->real_escape_string($data['city']);

        $sql = "INSERT INTO commandes (first_name, last_name, address, city) VALUES ('$firstName', '$lastName', '$address', '$city')";

        if ($mysqli->query($sql) === true) {
            $orderId = $mysqli->insert_id;
            $mysqli->close();
            return $orderId;
        } else {
            echo json_encode(['error' => 'Erreur lors de l\'enregistrement de la commande dans la base de données']);
            http_response_code(500);
            exit();
        }
    }
}

$paymentProcessor = new ProcessPayment();
$paymentProcessor->handlePayment();
?>
