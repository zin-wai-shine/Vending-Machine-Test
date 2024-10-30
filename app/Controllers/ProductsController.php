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
    public function confirmed()
    {

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
    public function getProduct($id)
    {

        $this->checkRole(1);
        $product = $this->getProductById($id);

        if ($product) {
            $_SESSION['product'] = $product;
            echo json_encode(['success' => true, 'product' => $product]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Product not found.']);
        }
    }
    public function toBuyingProcess($name) {
        if (isset($_SESSION['product'])) {
            $product = $_SESSION['product'];
            include __DIR__ . '/../Views/Purchase/buying_process.php';
        } else {
            echo "No product found in session.";
        }
    }
    public function next($name)
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $_SESSION['buying_count'] = $data['buying_count'];
        header('Content-Type: application/json');
        $isConfirmed = true;
        if ($isConfirmed) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Confirmation failed.']);
        }
    }
    public function confirmation($name)
    {
        include __DIR__ . '/../Views/Purchase/confirm.php';
    }
    public function showPurchase()
    {
        $this->checkRole(1);
        $stmt = $this->db->prepare("SELECT * FROM products");
        $stmt->execute();
        $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        include __DIR__ . '/../Views/Purchase/purchase.php';
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

    public function transaction()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $this->db->beginTransaction();

        try {
            $stmt = $this->db->prepare("INSERT INTO transactions (product_id, user_id, quantity, total_price) VALUES (:product_id, :user_id, :quantity, :total_price)");
            $stmt->execute([
                ':product_id' => $data['product_id'],
                ':user_id' => $_SESSION['user_id'],
                ':quantity' => $data['quantity'],
                ':total_price' => $data['total_price']
            ]);

            $updateStmt = $this->db->prepare("UPDATE products SET quantity_available = quantity_available - :quantity WHERE id = :product_id");
            $updateStmt->execute([
                ':quantity' => $data['quantity'],
                ':product_id' => $data['product_id']
            ]);

            $this->db->commit();

            echo json_encode(['success' => true, 'message' => 'Transaction successful! Quantity updated.']);
        } catch (\Exception $e) {
            $this->db->rollBack();
            echo json_encode(['success' => false, 'message' => 'Transaction failed: ' . $e->getMessage()]);
        }
    }


    public function transactions()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (isset($_GET['clear_filter']) && !empty($_GET['clear_filter'])) {
            unset($_SESSION['selected_product_id']);
            unset($_SESSION['selected_product_name']);
        }
        if (isset($_GET['product_id']) && !empty($_GET['product_id'])) {
            $_SESSION['selected_product_id'] = (int)$_GET['product_id'];
            $_SESSION['selected_product_name'] = $_GET['product_name'];
        }

        $itemsPerPage = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $itemsPerPage;

        $query = "
        SELECT transactions.id, users.username AS user_name, products.name AS product_name, 
               transactions.quantity, transactions.total_price, transactions.transaction_date
        FROM transactions
        JOIN users ON transactions.user_id = users.id
        JOIN products ON transactions.product_id = products.id
    ";

        $productId = isset($_SESSION['selected_product_id']) ? $_SESSION['selected_product_id'] : null;

        if ($productId) {
            $query .= " WHERE transactions.product_id = :product_id";
        }

        // Prepare total count query
        $totalStmt = $this->db->prepare("SELECT COUNT(*) AS total FROM transactions" . ($productId ? " WHERE product_id = :product_id" : ""));
        if ($productId) {
            $totalStmt->bindParam(':product_id', $productId, \PDO::PARAM_INT);
        }
        $totalStmt->execute();
        $totalResult = $totalStmt->fetch(\PDO::FETCH_ASSOC);
        $totalItems = $totalResult['total'];
        $totalPages = ceil($totalItems / $itemsPerPage);

        // Prepare the transactions query with pagination
        $stmt = $this->db->prepare($query . " LIMIT :limit OFFSET :offset");
        if ($productId) {
            $stmt->bindParam(':product_id', $productId, \PDO::PARAM_INT);
        }
        $stmt->bindParam(':limit', $itemsPerPage, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        $transactions = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Fetch products for the dropdown
        $stmt = $this->db->prepare("SELECT * FROM products ORDER BY name, id");
        $stmt->execute();
        $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Render the view with transactions and products
        include __DIR__ . '/../Views/products/transactions.php';
    }


    public function users()
    {
        $this->checkRole(0);

        $itemsPerPage = 5;

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $itemsPerPage;

        $totalStmt = $this->db->prepare("SELECT COUNT(*) AS total FROM users");
        $totalStmt->execute();
        $totalResult = $totalStmt->fetch(\PDO::FETCH_ASSOC);
        $totalItems = $totalResult['total'];

        $totalPages = ceil($totalItems / $itemsPerPage);

        $stmt = $this->db->prepare("SELECT * FROM users LIMIT :limit OFFSET :offset");
        $stmt->bindParam(':limit', $itemsPerPage, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();
        $users = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        include __DIR__ . '/../Views/products/users.php';
    }




}
