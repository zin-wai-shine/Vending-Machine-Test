<?php
namespace App\Core;

class Router {
    private $routes = [];

    // Register a route for GET requests
    public function get($uri, $action) {
        $uri = preg_replace('/\:(\w+)/', '(?P<$1>[^/]+)', $uri);
        $this->routes['GET'][$uri] = $action;
    }

    // Register a route for POST requests
    public function post($uri, $action) {
        $this->routes['POST'][$uri] = $action;
    }

    // Register a route for PUT requests
    public function put($uri, $action) {
        $this->routes['PUT'][$uri] = $action;
    }

    // Register a route for DELETE requests
    public function delete($uri, $action) {
        $this->routes['DELETE'][$uri] = $action;
    }
    public function dispatch($requestUri, $requestMethod) {
        // Strip query parameters from the URI
        $requestUri = strtok($requestUri, '?');

        if (isset($this->routes[$requestMethod])) {
            foreach ($this->routes[$requestMethod] as $uri => $action) {
                if (preg_match("#^$uri$#", $requestUri, $matches)) {
                    // Extract parameters from the matched route
                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                    // Check if the action is a Closure
                    if ($action instanceof Closure) {
                        // Call the Closure directly with parameters
                        return call_user_func_array($action, $params);
                    }

                    // Assuming $action is an array of [ControllerClass, methodName]
                    $controller = new $action[0]; // Instantiate the controller
                    $method = $action[1]; // Get the method name
                    return call_user_func_array([$controller, $method], $params); // Call the method with parameters
                }
            }
        }

        // Handle 404 Not Found if no route matches
        http_response_code(404);
        echo "404 Not Found";
    }

}
