<?php
require_once 'db.php';

class Panier
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getCartItems()
    {
        session_start();

        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            $cartItems = array();
            $productIds = implode(",", $_SESSION['cart']);

            $query = "SELECT p.id, p.name, p.price, p.image 
                      FROM products p 
                      INNER JOIN panier c ON p.id = c.product_id 
                      WHERE c.product_id IN ($productIds)
                      ORDER BY FIELD(c.product_id, $productIds)";
            
            $stmt = $this->pdo->query($query);

            if ($stmt) {
                while ($row = $stmt->fetch()) {
                    $product = array(
                        'id' => $row['id'],
                        'name' => $row['name'],
                        'price' => $row['price'],
                        'image' => $row['image']
                    );
                    $cartItems[] = $product;
                }
            } else {
                die('Erreur lors de l\'exécution de la requête SQL : ' . $this->pdo->errorInfo()[2]);
            }

            return $cartItems;
        } else {
            return array();
        }
    }
}

$panier = new Panier($pdo);
$cartItems = $panier->getCartItems();

header('Content-Type: application/json');
echo json_encode($cartItems);
?>
