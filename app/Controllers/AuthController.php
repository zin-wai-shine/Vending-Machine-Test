<?php
namespace App\Controllers;
use App\Core\Database;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
require_once '../config/config.php';

class AuthController{
    private $db;

    public function __construct(){
        $base_url = BASE_URL;
        $this->db = (new Database())->getConnection();
    }

    public function showLogin(){
        $filePath = __DIR__ . '/../Views/auth/login.php';
        if (file_exists($filePath)) {
            require $filePath;
        } else {
            http_response_code(404);
            echo "404 Not Found";
        }
    }

    public function showRegister() {
        $filePath = __DIR__ . '/../Views/auth/register.php';
        if (file_exists($filePath)) {
            require $filePath;
        } else {
            http_response_code(404);
            echo "404 Not Found";
        }
    }

    public function register() {
        $data = [
            'username' => $_POST['username'] ?? null,
            'email' => $_POST['email'] ?? null,
            'password' => $_POST['password'] ?? null,
        ];

        $errors = [];

        if (empty($data['username'])) {
            $errors['username'] = 'Username is required';
        }
        if (empty($data['email'])) {
            $errors['email'] = 'Email is required';
        }
        if (empty($data['password'])) {
            $errors['password'] = 'Password is required';
        }

        if (!empty($errors)) {
            echo json_encode(['success' => false, 'errors' => $errors]);
            return;
        }

        if (isset($data['username'], $data['email'], $data['password'])) {
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            $query = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
            $stmt = $this->db->prepare($query);

            $stmt->bindParam(":username", $data['username']);
            $stmt->bindParam(":email", $data['email']);
            $stmt->bindParam(":password", $hashedPassword);

            if ($stmt->execute()) {
                $key = bin2hex(random_bytes(32));
                $userId = $this->db->lastInsertId();
                $payload = [
                    "iss" =>  $base_url,
                    "aud" =>  $base_url,
                    "iat" => time(),
                    "nbf" => time(),
                    "data" => [
                        "id" => $userId,
                        "username" => $data['username'],
                        "email" => $data['email']
                    ]
                ];

                $jwt = JWT::encode($payload, $key, 'HS256');

                echo json_encode(['success' => true, 'message' => 'Sign up successfully!', 'token' => $jwt]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Sign up failed!']);
            }
        }
    }


    public function login(){
        $data = [
            'email' => $_POST['email'] ?? null,
            'password' => $_POST['password'] ?? null,
        ];

        $errors = [];

        if (empty($data['email'])) {
            $errors['email'] = 'Email is required';
        }
        if (empty($data['password'])) {
            $errors['password'] = 'Password is required';
        }

        if (!empty($errors)) {
            echo json_encode(['success' => false, 'errors' => $errors]);
            return;
        }

        $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $data['email']);
        $stmt->execute();
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);


        if ($user) {
            if (password_verify($data['password'], $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];

                $key = bin2hex(random_bytes(32));
                $payload = [
                    "iss" =>  $base_url,
                    "iat" => time(), //
                    "user" => [
                        "id" => $user['id'],
                        "username" => $user['username'],
                        "email" => $user['email'],
                        "role" => $user['role']
                    ]
                ];
                $jwt = JWT::encode($payload, $key, 'HS256');
                echo json_encode([
                    'success' => true,
                    'message' => 'Login successful!',
                    'token' => $jwt
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
        }
    }

    public function logout(){
        session_destroy();
        header("location: /login");
        exit();
    }

    public function isAuthenticated() {
        return isset($_SESSION['user_id']);
    }

    public function getUserRole() {
        return $_SESSION['role'] ?? null;
    }


}