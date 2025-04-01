<?php
// app/core/Route.php
namespace Core;

class Route {
    private static $routes = [];
    private static $pathNotFound = null;
    private static $methodNotAllowed = null;

    public static function add($method, $route, $target, $middleware = null) {
        self::$routes[$method][$route] = [
            'target' => $target,
            'middleware' => $middleware
        ];
    }

    // HTTP verb methods (unchanged)
    public static function get($route, $target, $middleware = null) {
        self::add('GET', $route, $target, $middleware);
    }

    public static function post($route, $target, $middleware = null) {
        self::add('POST', $route, $target, $middleware);
    }

    public static function put($route, $target, $middleware = null) {
        self::add('PUT', $route, $target, $middleware);
    }

    public static function patch($route, $target, $middleware = null) {
        self::add('PATCH', $route, $target, $middleware);
    }

    public static function delete($route, $target, $middleware = null) {
        self::add('DELETE', $route, $target, $middleware);
    }

    // Error handlers (unchanged)
    public static function pathNotFound($function) {
        self::$pathNotFound = $function;
    }

    public static function methodNotAllowed($function) {
        self::$methodNotAllowed = $function;
    }

    public static function run($basepath = '/') {
        $parsed_url = parse_url($_SERVER['REQUEST_URI']);
        $path = $parsed_url['path'];
        $method = $_SERVER['REQUEST_METHOD'];
        
        // Handle JSON input
        if (strpos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') !== false) {
            $input = file_get_contents('php://input');
            $_REQUEST = array_merge($_REQUEST, json_decode($input, true) ?? []);
        }

        // Normalize paths
        $basepath = rtrim($basepath, '/');
        $path = rtrim($path, '/');
    
        $path_match_found = false;
        $route_match_found = false;

        foreach (self::$routes as $route_method => $routes) {
            foreach ($routes as $route => $route_data) {
                $route = rtrim($route, '/');
                $full_route = ($basepath === '' || $basepath === '/') ? $route : $basepath . $route;
                
                $pattern = '#^' . preg_replace('/\/:([^\/]+)/', '/(?<$1>[^/]+)', $full_route) . '$#';
                
                if (preg_match($pattern, $path, $matches)) {
                    $path_match_found = true;
                    if (strtoupper($method) === strtoupper($route_method)) {
                        $route_match_found = true;

                        // Handle middleware through MiddlewareKernel
                        if (!empty($route_data['middleware'])) {
                            $middlewares = is_array($route_data['middleware']) 
                                ? $route_data['middleware'] 
                                : [$route_data['middleware']];
                            
                            MiddlewareKernel::handle($middlewares);
                        }

                        // Handle controller/closure
                        $target = $route_data['target'];
                        if (is_string($target) && strpos($target, '@') !== false) {
                            list($controller, $methodName) = explode('@', $target);
                            $controller = "App\\Controllers\\" . $controller;
                            if (class_exists($controller)) {
                                $controller = new $controller();
                                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                                call_user_func_array([$controller, $methodName], $params);
                                return;
                            }
                        } elseif (is_callable($target)) {
                            $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                            call_user_func_array($target, $params);
                            return;
                        }
                        return;
                    }
                }
            }
        }

        // Error handling (unchanged)
        if (!$path_match_found) {
            header('HTTP/1.0 404 Not Found');
            if (self::$pathNotFound) {
                call_user_func(self::$pathNotFound);
            } else {
                echo "404 - Not Found";
            }
            return;
        }

        if ($path_match_found && !$route_match_found) {
            header('HTTP/1.0 405 Method Not Allowed');
            if (self::$methodNotAllowed) {
                call_user_func(self::$methodNotAllowed);
            } else {
                echo "405 - Method Not Allowed";
            }
            return;
        }
    }
}