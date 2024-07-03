<?php
// Activer l'affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'db.php'; // Assurez-vous que ce fichier contient votre connexion PDO à la base de données

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
                return ['status' => 'success'];
            } else {
                return ['status' => 'error', 'message' => 'Failed to delete product'];
            }
        } catch (PDOException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}

// Exemple d'utilisation :
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pdo = require 'db.php'; // Inclure votre connexion PDO ici
    $deleteHandler = new Delete($pdo);

    $id = $_POST['id'];

    $result = $deleteHandler->deleteProduct($id);
    echo json_encode($result);
}
?>
