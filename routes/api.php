<?php
use App\Controllers\ProductsController;
use App\Controllers\AuthController;
use App\Core\Router;

$router = new Router();
$authMiddleware = new \App\Middleware\AuthMiddleware();

$router->get('/login', [AuthController::class, 'showLogin']);
$router->get('/logout', [AuthController::class, 'logout']);
$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/sign_in', [AuthController::class, "login"]);
$router->post('/sign_up', [AuthController::class, "register"]);

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 1) {
        $router->get('/', [ProductsController::class, 'showPurchase']);
    } else {
        $router->get('/', [ProductsController::class, 'getAllProducts']);
    }
} else {
    $router->get('/', [AuthController::class, 'showLogin']);
}

$router->get('/products', [ProductsController::class, 'getAllProducts']);
$router->post('/add_new_product', [ProductsController::class, 'createProduct']);
$router->get('/get_edit_product/:id', [ProductsController::class, 'getEditProduct']);
$router->get('/products/:id', [ProductsController::class, 'getProduct']);
$router->get('/product/:name', [ProductsController::class, 'toBuyingProcess']);
$router->post('/product/{name}/next', [ProductsController::class, 'next']);
$router->get('/product/:name/confirmation', [ProductsController::class, 'confirmation']);
$router->post('/confirmed', [ProductsController::class, 'confirmed']);
$router->post('/update_product', [ProductsController::class, 'updateProduct']);
$router->post('/delete_product', [ProductsController::class, 'deleteProduct']);
$router->post('/transaction', [ProductsController::class, 'transaction']);
$router->get('/transactions', [ProductsController::class, 'transactions']);
$router->get('/users', [ProductsController::class, 'users']);
return $router;

