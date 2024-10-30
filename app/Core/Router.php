<?php
namespace App\Core;

class Router {
    private $routes = [];

    // Register a route for GET requests
    public function get($uri, $action) {
        $this->registerRoute('GET', $uri, $action);
    }

    // Register a route for POST requests
    public function post($uri, $action) {
        $this->registerRoute('POST', $uri, $action);
    }

    // Register a route for PUT requests
    public function put($uri, $action) {
        $this->registerRoute('PUT', $uri, $action);
    }

    // Register a route for DELETE requests
    public function delete($uri, $action) {
        $this->registerRoute('DELETE', $uri, $action);
    }

    // A helper method to register routes
    private function registerRoute($method, $uri, $action) {
        // Replace both {param} and :param with regex to capture parameters
        $uri = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $uri); // For {param}
        $uri = preg_replace('/\:(\w+)/', '(?P<$1>[^/]+)', $uri); // For :param
        $this->routes[$method][$uri] = $action;
    }

    public function dispatch($requestUri, $requestMethod) {
        // Strip query parameters from the URI
        $requestUri = strtok($requestUri, '?');

        // Check if there are any routes defined for the request method
        if (isset($this->routes[$requestMethod])) {
            foreach ($this->routes[$requestMethod] as $uri => $action) {
                // Use regex to check if the URI matches
                if (preg_match("#^$uri$#", $requestUri, $matches)) {
                    // Extract parameters from the matched route
                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                    // Check if the action is a Closure
                    if ($action instanceof Closure) {
                        // Call the Closure directly with parameters
                        return call_user_func_array($action, $params);
                    }

                    // Assuming $action is an array of [ControllerClass, methodName]
                    if (is_array($action) && count($action) === 2) {
                        $controllerClass = $action[0]; // Controller class name
                        $method = $action[1]; // Method name

                        // Check if the controller class exists
                        if (class_exists($controllerClass)) {
                            $controller = new $controllerClass; // Instantiate the controller
                            // Check if the method exists in the controller
                            if (method_exists($controller, $method)) {
                                return call_user_func_array([$controller, $method], $params); // Call the method with parameters
                            } else {
                                // Handle the case where the method doesn't exist
                                http_response_code(404);
                                echo "Method $method not found in controller $controllerClass.";
                                return;
                            }
                        } else {
                            // Handle the case where the controller doesn't exist
                            http_response_code(404);
                            echo "Controller $controllerClass not found.";
                            return;
                        }
                    } else {
                        // Handle the case where the action is neither Closure nor valid controller action
                        http_response_code(500);
                        echo "Invalid action for route.";
                        return;
                    }
                }
            }
        }

        // Handle 404 Not Found if no route matches
        http_response_code(404);
        echo "404 Not Found";
    }

}
