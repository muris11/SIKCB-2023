<?php
namespace App\Core;

class Router {
    private array $routes = [];
    

    // di class Router
protected string $basePath = '';
public function setBasePath(string $basePath): void {
  $this->basePath = rtrim($basePath, '/');
}

// Removed duplicate dispatch method


    public function get(string $path, array $handler): void {
        $this->addRoute('GET', $path, $handler);
    }
    
    public function post(string $path, array $handler): void {
        $this->addRoute('POST', $path, $handler);
    }
    
    private function addRoute(string $method, string $path, array $handler): void {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler
        ];
    }
    
    public function dispatch(): void {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = $_SERVER['REQUEST_URI'];
        
        // Remove query string
        $requestUri = strtok($requestUri, '?');
        
        // Remove base path if exists
        if ($this->basePath && strpos($requestUri, $this->basePath) === 0) {
            $requestUri = substr($requestUri, strlen($this->basePath));
        }
        
        // Ensure starts with /
        if (empty($requestUri) || $requestUri[0] !== '/') {
            $requestUri = '/' . $requestUri;
        }
        
        foreach ($this->routes as $route) {
            if ($route['method'] !== $requestMethod) {
                continue;
            }
            
            $pattern = $this->convertPathToRegex($route['path']);
            
            if (preg_match($pattern, $requestUri, $matches)) {
                array_shift($matches); // Remove full match
                $this->callHandler($route['handler'], $matches);
                return;
            }
        }
        
        // No route matched
        throw new \Exception('Route not found');
    }
    
    private function convertPathToRegex(string $path): string {
        // Convert {id} to (\d+) and other parameters to ([^/]+)
        $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $path);
        return '#^' . $pattern . '$#';
    }
    
    private function callHandler(array $handler, array $params): void {
        [$controllerClass, $method] = $handler;
        
        $controller = new $controllerClass();
        
        if (method_exists($controller, $method)) {
            call_user_func_array([$controller, $method], $params);
        } else {
            throw new \Exception("Method {$method} not found in controller {$controllerClass}");
        }
    }
}
