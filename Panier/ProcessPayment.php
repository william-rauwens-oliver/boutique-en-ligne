<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';

\Stripe\Stripe::setApiKey('sk_test_51PVZNhLVIZdra2mGGzBdXvBMej3NCFBRu0KOOtxOogk1CwM4zaEouutMFQ0ymORrTMqjptLwPiMys9Ycuh8qx9Ka00Uz1SLmci'); // Remplacez par votre clé secrète Stripe

class ProcessPayment
{
    public function handlePayment()
    {
        header('Content-Type: application/json');

        // Récupérer les données POST
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        // Valider les données d'entrée
        if (!isset($data['payment_method_id'])) {
            echo json_encode(['error' => 'Invalid payment method ID']);
            http_response_code(400);
            exit();
        }

        try {
            // Créer un PaymentIntent avec le montant de la commande et la devise
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => 1000, // Montant en centimes (ajustez selon vos besoins)
                'currency' => 'eur', // Devise (ajustez selon vos besoins)
                'payment_method' => $data['payment_method_id'],
                'confirmation_method' => 'manual',
                'confirm' => true,
            ]);

            // Enregistrer la commande dans la base de données
            $orderId = $this->saveOrderToDatabase($data);

            echo json_encode(['success' => true, 'order_id' => $orderId]);
        } catch (\Stripe\Exception\CardException $e) {
            // Afficher l'erreur côté client
            echo json_encode(['error' => $e->getError()->message]);
            http_response_code(400);
        } catch (Exception $e) {
            // Capturer les autres exceptions et afficher l'erreur
            echo json_encode(['error' => $e->getMessage()]);
            http_response_code(500);
        }
    }

    // Fonction pour enregistrer la commande dans la base de données
    private function saveOrderToDatabase($data)
    {
        // Connexion à votre base de données (exemple avec MySQLi)
        $mysqli = new mysqli('localhost', 'root', 'root', 'boutique');

        // Vérifier la connexion
        if ($mysqli->connect_error) {
            die('Erreur de connexion à la base de données : ' . $mysqli->connect_error);
        }

        // Récupérer les informations de l'utilisateur depuis les données POST (nom, adresse, etc.)
        $firstName = $mysqli->real_escape_string($data['first_name']);
        $lastName = $mysqli->real_escape_string($data['last_name']);
        $address = $mysqli->real_escape_string($data['address']);
        $city = $mysqli->real_escape_string($data['city']);

        // Insérer la commande dans la table 'commandes'
        $sql = "INSERT INTO commandes (first_name, last_name, address, city) VALUES ('$firstName', '$lastName', '$address', '$city')";

        if ($mysqli->query($sql) === true) {
            $orderId = $mysqli->insert_id; // Récupérer l'ID de la commande insérée
            $mysqli->close(); // Fermer la connexion à la base de données
            return $orderId;
        } else {
            echo json_encode(['error' => 'Erreur lors de l\'enregistrement de la commande dans la base de données']);
            http_response_code(500);
            exit();
        }
    }
}

// Instancier la classe et appeler la méthode pour gérer le paiement
$paymentProcessor = new ProcessPayment();
$paymentProcessor->handlePayment();
?>
