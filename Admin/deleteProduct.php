<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'db.php'; 

class Delete
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function deleteProduct($id)
    {
        try {
            $sql = 'DELETE FROM products WHERE id = ?';
            $stmt = $this->pdo->prepare($sql);

            if ($stmt->execute([$id])) {
                $rowCount = $stmt->rowCount();
                if ($rowCount > 0) {
                    return ['status' => 'success'];
                } else {
                    return ['status' => 'error', 'message' => 'Aucun produit trouvé avec cet ID'];
                }
            } else {
                return ['status' => 'error', 'message' => 'Échec de la suppression du produit'];
            }
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pdo = require 'db.php';
    $deleteHandler = new Delete($pdo);

    $id = $_POST['id'];

    $result = $deleteHandler->deleteProduct($id);
    echo json_encode($result);
}
?>
