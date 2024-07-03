<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

class Panier
{
    private $conn;

    public function __construct($host, $username, $password, $dbname)
    {
        $this->conn = new mysqli($host, $username, $password, $dbname);
        if ($this->conn->connect_error) {
            die("Erreur de connexion à la base de données : " . $this->conn->connect_error);
        }
    }

    public function getCartItems()
    {
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            $cartItems = array();
            $productIds = implode(",", $_SESSION['cart']);

            $query = "SELECT p.id, p.name, p.price, p.image 
                      FROM products p 
                      INNER JOIN panier c ON p.id = c.product_id 
                      WHERE c.product_id IN ($productIds)
                      ORDER BY FIELD(c.product_id, $productIds)";
            
            $result = $this->conn->query($query);

            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $product = array(
                        'id' => $row['id'],
                        'name' => $row['name'],
                        'price' => $row['price'],
                        'image' => $row['image']
                    );
                    $cartItems[] = $product;
                }
                $result->free();
            } else {
                die('Erreur lors de l\'exécution de la requête SQL : ' . $this->conn->error);
            }

            return $cartItems;
        } else {
            return array();
        }
    }

    public function closeConnection()
    {
        $this->conn->close();
    }
}

// Utilisation de la classe Panier
$panier = new Panier('localhost', 'root', 'root', 'boutique');
$cartItems = $panier->getCartItems();
$panier->closeConnection();

header('Content-Type: application/json');
echo json_encode($cartItems);
?>
