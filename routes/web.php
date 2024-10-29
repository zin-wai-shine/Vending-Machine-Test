<?php
use App\Controllers\ProductsController;
use App\Controllers\AuthController;
use App\Core\Router;

$router = new Router();

$router->get('/login', [AuthController::class, 'showLogin']);
$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/sign_in', [AuthController::class, "login"]);
$router->post('/sign_up', [AuthController::class, "register"]);

$router->get('/', [ProductsController::class, 'showPurchase']);

//$router->get('/', [ProductsController::class, 'getAllProducts']);

$router->get('/products', [ProductsController::class, 'getAllProducts']);
$router->post('/add_new_product', [ProductsController::class, 'createProduct']);
$router->get('/get_edit_product/:id', [ProductsController::class, 'getEditProduct']);
$router->post('/update_product', [ProductsController::class, 'updateProduct']);
$router->post('/delete_product', [ProductsController::class, 'deleteProduct']);
return $router;

// User Authentication Routes
//$router->add('GET', '/login', 'AuthController@showLogin');
//$router->add('POST', '/login', 'AuthController@login');
//$router->add('GET', '/register', 'AuthController@showRegister');
//$router->add('POST', '/register', 'AuthController@register');
//$router->add('GET', '/logout', 'AuthController@logout');

// Product CRUD Routes
//$router->add('GET', '/products', 'ProductsController@index');
//$router->add('GET', '/products/create', 'ProductsController@create');
//$router->add('POST', '/products/store', 'ProductsController@store');
//$router->add('GET', '/products/edit', 'ProductsController@edit');
//$router->add('POST', '/products/update', 'ProductsController@update');
//$router->add('GET', '/products/delete', 'ProductsController@delete');
//$router->add('POST', '/products/purchase', 'ProductsController@purchaseProduct');

