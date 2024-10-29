<?php
namespace App\Controllers;

use App\Core\Database;
use App\Middleware\AuthMiddleware;

class ProductsController extends AuthMiddleware {
    private $db;

    public function __construct() {
        $this->checkLoggedIn();
        $database = new Database();
        $this->db = $database->getConnection();
    }
    public function getProductById($id) {
        $query = 'SELECT * FROM products WHERE id = :id LIMIT 1';
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getAllProducts() {
        $itemsPerPage = 5;

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $itemsPerPage;

        $totalStmt = $this->db->prepare("SELECT COUNT(*) AS total FROM products");
        $totalStmt->execute();
        $totalResult = $totalStmt->fetch(\PDO::FETCH_ASSOC);
        $totalItems = $totalResult['total'];

        $totalPages = ceil($totalItems / $itemsPerPage);

        $stmt = $this->db->prepare("SELECT * FROM products LIMIT :limit OFFSET :offset");
        $stmt->bindParam(':limit', $itemsPerPage, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        include __DIR__ . '/../Views/products/index.php';
    }
    public function createProduct() {
        $this->checkRole(0);

        $data = json_decode(file_get_contents("php://input"), true);

        $errors = [];

        if (empty($data['name'])) {
            $errors['name'] = 'Name is required';
        }
        if (empty($data['price'])) {
            $errors['price'] = 'Price is required';
        }
        if (empty($data['quantity'])) {
            $errors['quantity'] = 'Quantity is required';
        }

        if (!empty($errors)) {
            echo json_encode(['success' => false, 'errors' => $errors]);
            return;
        }

        if (isset($data['name'], $data['price'], $data['quantity'])) {
            $stmt = $this->db->prepare("INSERT INTO products (name, price, quantity_available) VALUES (:name, :price, :quantity)");
            $stmt->execute([
                ':name' => $data['name'],
                ':price' => $data['price'],
                ':quantity' => $data['quantity']
            ]);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid input data']);
        }
    }
    public function updateProduct() {
        $this->checkRole(0);

        // Get data from POST request
        $data = [
            'id' => $_POST['id'] ?? null,
            'name' => $_POST['name'] ?? null,
            'price' => $_POST['price'] ?? null,
            'quantity' => $_POST['quantity'] ?? null,
        ];

        $errors = [];

        // Validation
        if (empty($data['name'])) {
            $errors['name'] = 'Name is required';
        }
        if (empty($data['price'])) {
            $errors['price'] = 'Price is required';
        } elseif (!is_numeric($data['price']) || $data['price'] <= 0) {
            $errors['price'] = 'Price must be a valid number greater than zero';
        }
        if (empty($data['quantity'])) {
            $errors['quantity'] = 'Quantity is required';
        } elseif (!is_numeric($data['quantity']) || $data['quantity'] < 0) {
            $errors['quantity'] = 'Quantity must be a valid number (0 or greater)';
        }

        // If there are validation errors, return them
        if (!empty($errors)) {
            echo json_encode(['success' => false, 'errors' => $errors]);
            return;
        }

        // Prepare the SQL update statement
        $stmt = $this->db->prepare("UPDATE products SET name = :name, price = :price, quantity_available = :quantity WHERE id = :id");
        $stmt->execute([
            ':id' => $data['id'],
            ':name' => $data['name'],
            ':price' => $data['price'],
            ':quantity' => $data['quantity']
        ]);

        echo json_encode(['success' => true, 'message' => 'Product updated successfully.']);

    }
    public function deleteProduct() {
        $this->checkRole(0);

        header('Content-Type: application/json');

        // Get JSON input
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['productId']) || !is_numeric($data['productId'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid product ID.']);
            return;
        }
        $productId = (int)$data['productId'];
        try {
            $stmt = $this->db->prepare("DELETE FROM products WHERE id = :id");
            $stmt->execute([':id' => $productId]);
            echo json_encode(['success' => true, 'message' => 'Product deleted successfully.']);

        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
        }
    }
    public function getEditProduct($id) {
        $product = $this->getProductById($id);
        if ($product) {
            echo json_encode(['success' => true, 'product' => $product]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Product not found.']);
        }
    }
    public function showPurchase()
    {
        $this->checkRole(1);
        $stmt = $this->db->prepare("SELECT * FROM products");
        $stmt->execute();
        $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        include __DIR__ . '/../Views/products/purchase.php';
    }
    public function purchaseProduct($productId, $userId, $quantity) {
        $this->db->beginTransaction();

        try {
            $stmt = $this->db->prepare("SELECT * FROM products WHERE id = :id");
            $stmt->execute([':id' => $productId]);
            $product = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (!$product || $product['quantity_available'] < $quantity) {
                throw new Exception("Insufficient stock.");
            }

            $totalPrice = $product['price'] * $quantity;

            $stmt = $this->db->prepare("UPDATE products SET quantity_available = quantity_available - :quantity WHERE id = :id");
            $stmt->execute([
                ':quantity' => $quantity,
                ':id' => $productId
            ]);

            $stmt = $this->db->prepare("INSERT INTO transactions (user_id, product_id, quantity, total_price, created_at) VALUES (:user_id, :product_id, :quantity, :total_price, NOW())");
            $stmt->execute([
                ':user_id' => $userId,
                ':product_id' => $productId,
                ':quantity' => $quantity,
                ':total_price' => $totalPrice
            ]);

            $this->db->commit();
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

}
